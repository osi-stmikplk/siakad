<?php
/**
 * Melakukan update terhadap data diri mahasiswa
 * User: toni
 * Date: 11/04/16
 * Time: 11:25
 */

namespace Stmik\Http\Controllers\Mahasiswa;


use Stmik\Factories\DataDiriFactory;
use Stmik\Http\Controllers\Controller;

class DataDiriController extends Controller
{

    /** @var DataDiriFactory */
    protected $factory;
    public function __construct(DataDiriFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Tampilkan form untuk data diri dan update tentunya
     * @return $this
     */
    public function index()
    {
        return view('mahasiswa.data-diri.index')
            ->with('layout', $this->getLayout());
    }
}