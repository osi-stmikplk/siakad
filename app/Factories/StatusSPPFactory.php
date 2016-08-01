<?php
/**
 * Mengatur status pembayaran SPP
 * User: toni
 * Date: 10/04/16
 * Time: 10:00
 */

namespace Stmik\Factories;


use Illuminate\Http\Request;
use Stmik\Mahasiswa;
use Stmik\StatusSPP;

class StatusSPPFactory extends AbstractFactory
{
    protected $statusTerakhir = StatusSPP::STATUS_BELUM_BAYAR;
    /** @var MahasiswaFactory  */
    protected $mahasiswaFactory;
    public function __construct(MahasiswaFactory $mahasiswaFactory)
    {
        $this->mahasiswaFactory = $mahasiswaFactory;
        parent::__construct();
    }

    /**
     * Kembalikan data yang akan di load oleh bootstrap table!
     * @param $pagination
     */
    public function getBTTable($pagination, Request $req)
    {
        // proses filter
        $filter = isset($pagination['otherQuery']['filter'])? $pagination['otherQuery']['filter']: [];
        $ta = isset($filter['ta'])? $filter['ta']: '00000'; // bila tidak ada TA di set maka kembalikan saja sembarang!
        $jurusan = isset($filter['jurusan'])? $filter['jurusan']: null;
        // generate builder terlebih dahulu ...
//        $builder = \DB::table('mahasiswa as m')
//            ->leftJoin(\DB::raw('(SELECT * FROM status_spp WHERE tahun_ajaran=?) as p'), 'p.mahasiswa_id', '=', 'm.nomor_induk');
        $builder = \DB::table('mahasiswa as m')
            ->leftJoin('status_spp as s', function ($join) use($ta) {
                $join->on('m.nomor_induk', '=', 's.mahasiswa_id')->where('s.tahun_ajaran', '=', $ta);
            })
            ->whereIn('m.status', $this->mahasiswaFactory->getStatusYangBolehIsiKRS()) // cari yang lagi aktif kuliah saja!
            ->select(['m.nomor_induk', 'm.nama', 's.status as status_bayar', 's.tahun_ajaran' ]);
        if($jurusan!==null) {
            $builder = $builder->where('m.jurusan_id', $jurusan);
        }
        return $this->getBTData($pagination,
            $builder,
            ['nomor_induk', 'nama', 'status_bayar'],
            ['status_bayar'=>'s.status']);
    }

    /**
     * Set status pembayaran SPP nya. Bila sebelumnya sudah diset maka kita asumsikan ini adalah reset. Bila tidak maka
     * set nilainya dengan 1 atau sudah terbayar.
     * @param $nim
     * @param $ta
     */
    public function setStatusNya($nim, $ta)
    {
        try {
            // dapatkan dulu nilai sebelumnya
            $m = StatusSPP::where('mahasiswa_id', $nim)->where('tahun_ajaran', $ta)->first();
            if($m===null) {
                // tidak ada data = baru saja dibuat
                $m = new StatusSPP();
                $m->status = StatusSPP::STATUS_SUDAH_BAYAR;
            } else {
                $m->status = (int) ! $m->status;
//                if($m->status==StatusSPP::STATUS_SUDAH_BAYAR)
//                    $m->status = StatusSPP::STATUS_BELUM_BAYAR;
//                else
//                    $m->status = StatusSPP::STATUS_SUDAH_BAYAR;
            }
            $m->mahasiswa_id = $nim;
            $m->tahun_ajaran = $ta;
            $m->save();
            $this->statusTerakhir = $m->status;

        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['nim'=>$nim, 'ta'=>$ta]);
            $this->errors->add('system', 'Tidak dapat melakukan setting, check Log');
        }
        return $this->errors->count() <= 0;
    }

    /**
     * Dapatkan nilai status terakhir yang di insert
     * @return int
     */
    public function getStatusTerakhirDiInsert()
    {
        return $this->statusTerakhir;
    }

    /**
     * Kembalikan data list tahun ajaran yang aktif saja untuk digunakan oleh filter
     * @return array
     */
    public static function loadListTAAktif()
    {
        $ta = ReferensiAkademikFactory::getTALists();
        // karena sudah di sorting, kembalikan 2 daftar TA terakhir
        return array_slice($ta, 0, 2, true);
    }

}