<?php
/**
 * Atur bagaimana nilai mahasiswa diinput, issue #33
 * User: toni
 * Date: 19/09/16
 * Time: 8:31
 */

namespace Stmik\Http\Controllers\Akma;

use Panatau\Tools\IntercoolerTrait;
use Stmik\Factories\NilaiMahasiswaFactory;
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

}