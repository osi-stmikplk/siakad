<?php
/**
 * Ini adalah controller untuk penampilan dan juga perhitungan Hasil Study Mahasiswa!.
 * Hasil study yang tampil di sini adalah milik Mahasiswa yang login.
 * User: toni
 * Date: 12/05/16
 * Time: 17:07
 */

namespace Stmik\Http\Controllers\Mahasiswa;


use Illuminate\Http\Request;
use Stmik\Factories\HasilStudyMahasiswaFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;
// nyontek dari IsiFRSController (banghaji)
use Stmik\Factories\MahasiswaFactory;

class HasilStudyController extends Controller
{
    use GetDataBTTableTrait;

    protected $factory;

    public function __construct(HasilStudyMahasiswaFactory $factory)
    {
        $this->factory = $factory;

        $this->middleware('auth.role:mahasiswa');
    }

    public function index()
    {
        return view('mahasiswa.hasil-study.index')
            ->with('data', $this->factory->getDataMahasiswa())
            ->with('layout', $this->getLayout());
    }

    /**
     * Tampilkan IPS untuk mahasiswa terpilih, namun apabila nilai param $nim tidak ada berarti yang login saat itu yang
     * mengaksesnya. Di load untuk ajax saja!
     * @param null $nim
     */
    public function ips(Request $request, $nim = null)
    {
        $nim = $this->factory->getNIM($nim);

        return view('mahasiswa.hasil-study.ips')
            ->with('nim', $nim)
            ->with('data', $this->factory->loadDataPerhitunganIPS($nim));
    }

    /**
     * Tampilkan perhitungan IPK, bila NIM tidak terpilih tampilkan yang saat itu aktif saja!
     * @param null $nim
     */
    public function ipk($nim = null)
    {
        // baca data mhs ybs (banghaji)
        $nim = $this->factory->getNIM($nim);
        $mhs = $this->factory->getDataMahasiswa($nim);

        // kirim data ke view (banghaji)
		return view('mahasiswa.hasil-study.ipk')
            ->with('mhs', $mhs)
            ->with('data', $this->factory->loadDataHasilStudy($nim));
    }
	
	// banghaji 20160622 untuk cetak KHS
    public function cetakKHS($semester, $nim = null)
    {
        // baca data mhs ybs (banghaji)
        $nim = $this->factory->getNIM($nim);
        $mhs = $this->factory->getDataMahasiswa($nim);

        // kirim data ke view (banghaji)
		return view('mahasiswa.hasil-study.khs')
            ->with('mhs', $mhs)
            ->with('semester', $semester)
            ->with('ta', $this->factory->tahunAjaranKapan($semester, $nim))
            ->with('data', $this->factory->loadDataHasilStudySemesteran($semester, $nim));
    }


}