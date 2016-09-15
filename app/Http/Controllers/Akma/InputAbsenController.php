<?php
/**
 * Controller input absensi Mahasiswa
 * User: toni
 * Date: 08/09/16
 * Time: 10:26
 */

namespace Stmik\Http\Controllers\Akma;


use Illuminate\Http\Request;
use Stmik\Factories\InputAbsenFactory;
use Stmik\Factories\ReferensiAkademikFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Requests\InputAbsenRequest;
use Stmik\PengampuKelas;

class InputAbsenController extends Controller
{

    protected $factory;

    public function __construct(InputAbsenFactory $factory)
    {
        $this->factory = $factory;
        $this->middleware('auth.role:akma');
    }

    /**
     * @return $this
     */
    public function index()
    {
        return view('akma.input-absen.index')
            ->with('layout', $this->getLayout());
    }

    /**
     * Saat user memilih Tahun Ajaran dan Jurusan maka load daftar kelas yang berkaitan dengannya!
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function loadKelasBerdasarkan(Request $request)
    {
        $tahunAjaran = $request->input('ta', ReferensiAkademikFactory::getTAAktif()->tahun_ajaran);
        $diJurusanIni = $request->input('jurusan');
        if($diJurusanIni===null) {
            return response("");
        }
        return response(load_select(
            $request->input('ic-target-id', 'daftar-kelas'),
            $this->factory->dapatkanKelas($tahunAjaran, $diJurusanIni),
            0, [], ['Pilih Mata Kuliah Akan Di Catat'], true
        ));
    }

    /**
     * Load daftar mahasiswa berdasarkan kepada request dari ic-request
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function loadDaftarMahasiswa(Request $request)
    {
        // karena dikirimkan menggunakan javascript lakukan proses pengambilan variable
        $idKelas = $request->input('kelas');
        return $this->loaderDaftarKelas($idKelas);
    }

    /**
     * Supaya bisa dipakai lagi seperti seorang panggilan yang pasrah dipanggil kapan saja oleh si pemanggil. maram...
     * @param $idKelas
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function loaderDaftarKelas($idKelas)
    {
        if($idKelas === null) {
            return response("Silahkan pilih kelas terlebih dahulu!");
        }
        $mahasiswaPengambil = $this->factory->dapatkanMahasiswaDi($idKelas);
        return view('akma.input-absen.load-daftar-mhs')
            ->with('kelas', $idKelas)
            ->with('pilihanKet', ['H'=>'Hadir', 'I'=>'Izin', 'S'=>'Sakit', 'TK'=>'Tanpa Keterangan!'])
            ->with('mahasiswaPengambil', $mahasiswaPengambil);
    }

    /**
     * Simpan saja hasil inputan
     * @param InputAbsenRequest $inputAbsenRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function simpan($kelas, InputAbsenRequest $inputAbsenRequest)
    {
        if($this->factory->simpan($inputAbsenRequest->all())) {
            return $this->loaderDaftarKelas($kelas)
                ->with('msg', 'Absensi telah diinputkan!');
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }
}