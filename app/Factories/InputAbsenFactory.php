<?php
/**
 * Atur pencatatan absensi Mahasiswa
 * User: toni
 * Date: 08/09/16
 * Time: 10:25
 */

namespace Stmik\Factories;


use Illuminate\Database\Query\Builder;
use Stmik\RencanaStudi;

class InputAbsenFactory extends AbstractFactory
{

    protected $dosenMKKelasFactory;
    public function __construct(DosenKelasMKFactory $dosenKelasMKFactory)
    {
        parent::__construct();
        $this->dosenMKKelasFactory = $dosenKelasMKFactory;
    }

    /**
     * Render array yang nantinya merupakan isi dari item di select
     * @param $tahunAjaran
     * @param $diJurusanIni
     * @return array'
     */
    public function dapatkanKelas($tahunAjaran, $diJurusanIni)
    {
        $result = $this->dosenMKKelasFactory->builderDapatkanKelasPada($tahunAjaran, $diJurusanIni)
            ->select(['pk.id', 'pk.kelas', 'mk.kode', 'mk.nama', 'mk.sks', 'mk.semester'])
            ->orderBy('mk.semester')
            ->get();
        $a = [];
        foreach ($result as $r) {
            $a[$r->id] = $r->kode . ' - ' . $r->kelas . ' - ' . $r->nama .
                " (" . $r->sks . " SKS - Semester " . $r->semester .")";
        }
        return $a;
    }

    /**
     * Kembalikan semua nama mahasiswa yang mengambil kelas di $idKelasIni
     * @param $idKelasIni
     */
    public function dapatkanMahasiswaDi($idKelasIni)
    {
        return \DB::table('rincian_studi as ris')
            ->join('rencana_studi as rs', 'rs.id', '=', 'ris.rencana_studi_id')
            ->join('mahasiswa as m', 'm.nomor_induk', '=', 'rs.mahasiswa_id')
            ->where('ris.kelas_diambil_id' , '=', $idKelasIni)
            ->where('rs.status', RencanaStudi::STATUS_DISETUJUI)
            ->select('m.nomor_induk', 'm.nama', 'ris.jumlah_kehadiran',
                'ris.absen_tanpa_keterangan',
                'ris.absen_ijin',
                'ris.absen_sakit',
                'ris.id as rincian_studi_id' // butuh ini untuk efisiensi, jadi tinggal update saja di rincian_study
            )
            ->orderBy('m.nomor_induk')
            ->get();
    }

    /**
     * Simpan hasil inputan yang diinputkan oleh user
     * @param $input
     */
    public function simpan($input)
    {
        // hapus semua inputan tanpa isi yang artinya tidak perlu diisi atau yang nilainya adalah nol
        $mahasiswaNya = array_filter($input['mhs'], function($v) {
            return strlen($v) > 0 && intval($v) != 0;
        });

        try {
            \DB::transaction(function () use ($mahasiswaNya, $input) {
                // this is the hell ...
                /** @var Builder $query */
                foreach ($mahasiswaNya as $nim=>$absen) {
                    $query = \DB::table('rincian_studi')->where('id', '=', $input['ris'][$nim]);
                    switch($input['ket'][$nim]) {
                        case 'H':
                            $query->increment('jumlah_kehadiran', $absen);
                            break;
                        case 'I':
                            $query->increment('absen_ijin', $absen);
                            break;
                        case 'TK':
                            $query->increment('absen_tanpa_keterangan', $absen);
                            break;
                        case 'S':
                            $query->increment('absen_sakit', $absen);
                            break;
                    }
                }
            });
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), []);
            $this->errors->add('sys', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }

}