<?php
/**
 * Ini adalah controller untuk penampilan dan juga perhitungan Hasil Study Mahasiswa!.
 * Hasil study yang tampil di sini adalah milik Mahasiswa yang login.
 * User: toni
 * Date: 12/05/16
 * Time: 17:07
 */

namespace Stmik\Http\Controllers\Mahasiswa;


use Stmik\Factories\HasilStudyMahasiswaFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;

class HasilStudyController extends Controller
{
    use GetDataBTTableTrait;

    protected $factory;

    public function __construct(HasilStudyMahasiswaFactory $factory)
    {
        $this->factory = $factory;
        $this->authorize('dataIniHanyaBisaDipakaiOleh', 'mahasiswa');
    }

    public function index()
    {
        return view('mahasiswa.hasil-study.index')
            ->with('data', $this->factory->getDataMahasiswa())
            ->with('layout', $this->getLayout());
    }


}