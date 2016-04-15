<?php
/**
 * Master Mahasiswa
 * todo: implementasi filter berdasarkan status mahasiswa!
 * Date: 11/04/16
 * Time: 12:54
 */

namespace Stmik\Http\Controllers\Master;

use Stmik\Factories\MasterMahasiswaFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;

class MahasiswaController extends Controller
{
    use GetDataBTTableTrait;
    /** @var MasterMahasiswaFactory  */
    protected $factory;

    public function __construct(MasterMahasiswaFactory $factory)
    {
        $this->factory = $factory;

        $this->authorize('mengaksesIniRolenyaHarus', 'akma');
    }

    public function index()
    {
        return view('master.mahasiswa.index')
            ->with('layout', $this->getLayout());
    }




}