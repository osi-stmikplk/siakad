<?php
/**
 * Untuk entry ke nilai mahasiswa
 * User: toni
 * Date: 19/09/16
 * Time: 8:30
 */

namespace Stmik\Factories;


use Illuminate\Database\Query\Builder;
use Stmik\Dosen;
use Stmik\Mahasiswa;
use Stmik\Pegawai;

class NilaiMahasiswaFactory extends AbstractFactory
{

    protected $dosenMKKelasFactory;
    public function __construct(DosenKelasMKFactory $dosenKelasMKFactory)
    {
        parent::__construct();
        $this->dosenMKKelasFactory = $dosenKelasMKFactory;
    }

    /**
     * Kalau pada bagian lain tidak melakukan proses pembacaan siapa yang login, maka di sini lakukan seleksi data apa
     * yang dikembalikan.
     * @param $tahunAjaran
     * @param $idJurusan
     */
    public function dapatkanDaftarKelas($tahunAjaran, $idJurusan)
    {
        $builder = $this->dosenMKKelasFactory->builderDapatkanKelasPada($tahunAjaran, $idJurusan);
        // khusus untuk nilai ini maka pastikan siapa yang login
        if(\Auth::user()->hasRole('dosen')) {
            // kalau yang login maka hanya yang diajarkan oleh dosen ini
            $builder = $builder->where('pk.dosen_id', '=', \Auth::user()->owner->nomor_induk);
        } else if(\Auth::user()->hasRole('akma')) {
            // ini adalah si akma, maka load semua :D
        } else if(\Auth::user()->hasRole('mahasiswa')) {
            // ini untuk si mahasiswa maka load tempat dia mengambil saja!
            $builder = $builder->join('rincian_studi as ris', 'ris.kelas_diambil_id', '=', 'pk.id')
                ->join('rencana_studi as rs', 'rs.id', '=', 'ris.rencana_studi_id')
                ->where('rs.mahasiswa_id', '=', \Auth::user()->name);
        }
        $result = $builder->get(['pk.id', 'pk.kelas', 'mk.kode', 'mk.nama', 'mk.sks', 'mk.semester']);
        $a = [];
        foreach ($result as $r) {
            $a[$r->id] = $r->kode . ' - ' . $r->kelas . ' - ' . $r->nama .
                " (" . $r->sks . " SKS - Semester " . $r->semester .")";
        }
        return $a;
    }

    /**
     * Dapatkan daftar mahasiswa dan field berkaitan dengan nilai
     * @param $idKelas
     * @return array|static[]
     */
    public function dapatkanMahasiswaDi($idKelas)
    {
        /** @var Builder $builderMahasiswa */
        $builderMahasiswa = $this->dosenMKKelasFactory->builderDapatkanMahasiswaPengambilKelas($idKelas);
        // ambil untuk di load
        $builderMahasiswa->select('mhs.nomor_induk', 'mhs.nama',
            'ris.nilai_tugas', 'ris.nilai_uts', 'ris.nilai_praktikum', 'ris.nilai_uas',
            'ris.nilai_akhir', 'ris.id as rincian_studi_id')
            ->orderBy('mhs.nomor_induk');

        return $builderMahasiswa->get();
    }
}