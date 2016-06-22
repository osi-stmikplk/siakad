<?php
/**
 * Mengatur proses persetujuan FRS oleh AKMA
 * User: toni
 * Date: 31/05/16
 * Time: 17:08
 */

namespace Stmik\Factories;


use Illuminate\Http\Request;

class PersetujuanFRSFactory extends AbstractFactory
{
    /** @var IsiFRSFactory */
    protected $isiFRSFactory;
    protected $mahasiswaFactory;
    public function __construct(IsiFRSFactory $isiFRSFactory, MahasiswaFactory $mahasiswaFactory)
    {
        parent::__construct();
        $this->mahasiswaFactory = $mahasiswaFactory;
        $this->isiFRSFactory = $isiFRSFactory;
    }

    /**
     * Load data untuk tampil.
     * NOTE: di sini saat mhs ybs belum melakukan pembuatan rencana studi maka sistem tidak akan melakukan loading
     * terhadap data mahasiswa ybs!
     * @param $pagination
     * @param Request $request
     * @return string
     */
    public function getBTTable($pagination, Request $request)
    {
        // proses filter
        $filter = isset($pagination['otherQuery']['filter'])? $pagination['otherQuery']['filter']: [];
        $jurusan = isset($filter['jurusan'][0]) ? $filter['jurusan']: 'NOTHING';
        $angkatan = isset($filter['angkatan'][0]) ? $filter['angkatan']: null;

        $builder = \DB::table('mahasiswa as m')
            ->join('jurusan as j', function($join) use($jurusan){
                $join->on('m.jurusan_id', '=', 'j.id');
                if($jurusan!==null) {
                    $join->where('j.id', '=', $jurusan);
                }
            })
            ->whereNotIn('m.status', $this->mahasiswaFactory->getStatusSudahTidakKuliahLagi())
            ->select(['m.nama', 'm.nomor_induk', 'm.jenis_kelamin', 'm.tahun_masuk', 'm.status']);
        // sekarang dengan rencana studi
        $builder = $builder->join('rencana_studi as rs', function($join){
            $join->on('m.nomor_induk', '=', 'rs.mahasiswa_id');
            $join->where('rs.tahun_ajaran', '=', ReferensiAkademikFactory::getTAAktif()->tahun_ajaran);
        })->addSelect('rs.status as status_FRS');

        if($angkatan!==null) {
            $builder = $builder->where('m.tahun_masuk', $angkatan);
        }

        return $this->getBTData($pagination,
            $builder,
            ['nomor_induk', 'nama', 'tahun_masuk', 'jenis_kelamin', 'm.status', 'status_FRS'],
            ['nama'=>'m.nama', 'status_FRS'=>'rs.status']  // karena ada yang double untuk nama maka mapping ke m.nama (mahasiswa)
        );
    }


}