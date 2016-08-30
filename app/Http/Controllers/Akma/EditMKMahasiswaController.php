<?php

namespace Stmik\Http\Controllers\Akma;

use Illuminate\Http\Request;

use Stmik\Factories\EditMKMahasiswaFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;
use Stmik\Http\Requests;

class EditMKMahasiswaController extends Controller
{
    use GetDataBTTableTrait;
    /** @var EditMKMahasiswaFactory */
    protected $factory;

    public function __construct(EditMKMahasiswaFactory $editMKMahasiswaFactory)
    {
        $this->factory = $editMKMahasiswaFactory;

        $this->middleware('auth.role:akma');
    }

    /**
     * index
     */
    public function index()
    {
        return view('akma.edit-mk-mahasiswa.index')
            ->with('layout', $this->getLayout());
    }
}
