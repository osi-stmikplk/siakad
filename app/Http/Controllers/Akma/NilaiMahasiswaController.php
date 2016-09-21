<?php
/**
 * Atur bagaimana nilai mahasiswa diinput, issue #33
 * User: toni
 * Date: 19/09/16
 * Time: 8:31
 */

namespace Stmik\Http\Controllers\Akma;

use Illuminate\Http\Request;
use Panatau\Tools\IntercoolerTrait;
use Stmik\Factories\NilaiMahasiswaFactory;
use Stmik\Factories\ReferensiAkademikFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;

class NilaiMahasiswaController extends Controller
{
    use IntercoolerTrait, GetDataBTTableTrait;

    protected $factory;
    public function __construct(NilaiMahasiswaFactory $nilaiMahasiswaFactory)
    {
        $this->factory = $nilaiMahasiswaFactory;
    }

    /**
     * Kembalikan index
     * @return $this
     */
    public function index()
    {
        return view('akma.nilai-mahasiswa.index')
            ->with('layout', $this->getLayout());
    }

    /**
     * Load kelas berdasarkan user yang login
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function loadKelas(Request $request)
    {
        $tahunAjaran = $request->input('ta', ReferensiAkademikFactory::getTAAktif()->tahun_ajaran);
        $diJurusanIni = $request->input('jurusan');
        if($diJurusanIni===null) {
            return response("");
        }
        return response(load_select(
            $request->input('ic-target-id', 'daftar-kelas'),
            $this->factory->dapatkanDaftarKelas($tahunAjaran, $diJurusanIni),
            0, [], ['Pilih Mata Kuliah Di Pilih'], true
        ));
    }

    /**
     * @param Request $request
     */
    public function loadDaftarMahasiswa(Request $request)
    {
        $idKelas = $request->input('kelas');
        return $this->loaderDaftarMahasiswaDi($idKelas);
    }

    /**
     * @param $idKelas
     */
    private function loaderDaftarMahasiswaDi($idKelas)
    {
        if($idKelas === null) {
            return response("Silahkan pilih kelas terlebih dahulu!");
        }
        $mahasiswaPengambil = $this->factory->dapatkanMahasiswaDi($idKelas);
        return view('akma.nilai-mahasiswa.load-daftar-mhs')
            ->with('kelas', $idKelas)
            ->with('mahasiswaPengambil', $mahasiswaPengambil);
    }

}