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
use Stmik\PengampuKelas;
use Stmik\Grade;

class NilaiMahasiswaFactory extends AbstractFactory
{

    protected $dosenMKKelasFactory;
    protected $gradeFactory;
    public function __construct(DosenKelasMKFactory $dosenKelasMKFactory, GradeFactory $gradeFactory)
    {
        parent::__construct();
        $this->dosenMKKelasFactory = $dosenKelasMKFactory;
        $this->gradeFactory = $gradeFactory;
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
            'ris.nilai_akhir', 'ris.id as rincian_studi_id', 'ris.nilai_huruf', 'ris.nilai_angka','ris.status_lulus')
            ->orderBy('mhs.nomor_induk');

        return $builderMahasiswa->get();
    }

    /**
     * Apakah data kelas ada pada TA yang aktif?
     * @param $idKelas
     * @return bool
     */
    public function checkKelasPadaTAAktif($idKelas)
    {
        return PengampuKelas::findOrFail($idKelas)->tahun_ajaran == ReferensiAkademikFactory::getTAAktif()->tahun_ajaran;
    }

    /**
     * Lakukan penyimpanan yang diinputkan oleh user! Pada inputan di $input maka akan terdapat beberapa item array yang
     * menunjukkan tujuannya. Item array tersebut akan secara otomatis oleh Laravel disimpan di $input. Adapun isi dari
     * inputan oleh user akan diwakilkan oleh kunci indeks, serta kunci indeks berikutnya adalah menunjukkan NIP untuk
     * mahasiswa ybs, seperti yang ditunjukkan oleh berikut:
     * $input['ris']['xyznipnya'] => rincian studi id
     * $input['tugas']['xyznipnya'] => nilai tugas
     * $input['uts']['xyznipnya'] => nilai uts
     * $input['uas']['xyznipnya'] => nilai uas
     * $input['praktikum']['xyznipnya'] => nilai praktikum
     * $input['nilai']['xyznipnya'] => nilai nilai akhirnya
     * @param $input
     */
    public function simpan($input)
    {
        try {
            \DB::transaction(function () use ($input) {
                // looping di setiap rincian studi nya saja!
                // DONE: ingat untuk konversi nilai ke huruf yang mengambil data dari inputan oleh akma!
                foreach ($input['ris'] as $nip=>$ris) {
                    $nilai_akhir = convert_to_float($input['akhir'][$nip]); // nilai akhir
                    $nilai_huruf = $this->gradeFactory->dapatkanGrade($nilai_akhir);
                    $nilai_angka = $this->gradeFactory->dapatkanGradeNilaiAngka($nilai_huruf);
                    $status_lulus = $this->gradeFactory->apakahGradeIniLulus($nilai_huruf) ?
                        Grade::GRADE_LULUS : Grade::GRADE_TIDAK_LULUS;
                    \DB::table('rincian_studi')
                        ->where('id', $ris)
                        ->update([
                            'nilai_tugas'=>convert_to_float($input['tugas'][$nip]),
                            'nilai_uts'=>convert_to_float($input['uts'][$nip]),
                            'nilai_praktikum'=>convert_to_float($input['praktikum'][$nip]),
                            'nilai_uas'=>convert_to_float($input['uas'][$nip]),
                            'nilai_akhir'=>$nilai_akhir,
                            'nilai_angka'=>$nilai_angka,
                            'nilai_huruf'=>$nilai_huruf,
                            'status_lulus'=>$status_lulus
                        ]);
                }
            });
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), []);
            $this->errors->add('sys', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }
}