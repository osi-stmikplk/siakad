<?php

namespace Stmik\Http\Controllers\Master;

use Illuminate\Http\Request;

use Stmik\Factories\MasterMahasiswaFactory;
use Stmik\Factories\MasterMataKuliahFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;
use Stmik\Http\Requests;
use Stmik\MataKuliah;

/**
 * Class MataKuliahController Digunakan untuk melakukan proses penyimpanan mata kuliah
 * @package Stmik\Http\Controllers\Master
 */
class MataKuliahController extends Controller
{
    use GetDataBTTableTrait;
    /** @var MasterMataKuliahFactory  */
    protected $factory;

    public function __construct(MasterMataKuliahFactory $factory)
    {
        $this->factory = $factory;
        $this->authorize('mengaksesIniRolenyaHarus', 'akma');
    }

    /**
     * Tampilkan index untuk mata kuliah
     * @return $this
     */
    public function index()
    {
        return view('master.mata-kuliah.index')
            ->with('layout', $this->getLayout());
    }

    /**
     * Lakukan validasi di sini karena kita tidak menggunakan form pada kiriman intercoolerjs
     * @param string $id id dari matakuliah
     * @param Request $request
     */
    protected function validateSelf($id, Request $request)
    {
        $request->merge(['id'=>$id]);
        $this->validate($request, [
            'id' => 'required|exists:mata_kuliah,id'
        ]);
    }

    /**
     * Set status milik mata kuliah, bila saat itu statusnya adalah aktif set menjadi hapus dan demikian sebaliknya
     * @param string $id kode id mata kuliah
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function setStatus($id, Request $request)
    {
        $this->validateSelf($id, $request);
        if($this->factory->setStatus($id)) {
            return view('master.mata-kuliah._btn-aksi-status')
                ->with('id', $id)
                ->with('statusAktif', $this->factory->getStatusTerakhirDiInsert() == MataKuliah::STATUS_AKTIF);
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }

    /**
     * Lakukan editing, kembalikan form untuk edit data mata kuliah ini!
     * @param string $id kode primary untuk matakuliah!
     */
    public function edit($id)
    {
        return view('master.mata-kuliah.form')
            ->with('layout', $this->getLayout())
            ->with('action', route('master.mk.update', ['id'=>$id]))
            ->with('data', $this->factory->getDataMataKuliah($id));
    }

    public function update($id, Requests\MataKuliahRequest $request)
    {
        $input = $request->all();
        $this->checkKode($input, $request);
        if($this->factory->update($this->factory->getDataMataKuliah($id),$input)) {
            return $this->edit($id)->with('success', 'Data berhasil di update, silahkan lanjutkan ...');
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }

    /**
     * Render tampilan form untuk menambahkan data mata kuliah
     * @return mixed
     */
    public function create()
    {
        return view('master.mata-kuliah.form')
            ->with('layout', $this->getLayout())
            ->with('action', route('master.mk.store'))
            ->with('data', null);
    }

    /**
     * @param $input
     * @param Requests\MataKuliahRequest $request
     * @return bool|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function checkKode($input, Requests\MataKuliahRequest $request)
    {
        if(!$request->kodeAdalahUniqueUntukJurusan($input['jurusan_id'], $input['kode'])) {
            return response(json_encode(['kode'=>['Kode tidak unique untuk jurusan terpilih']]), 422);
        }
        return true;
    }

    /**
     * Simpan Mata Kuliah baru
     * @param Requests\MataKuliahRequest $request
     */
    public function store(Requests\MataKuliahRequest $request)
    {
        $input = $request->all();
        $this->checkKode($input, $request);
        if($this->factory->store($input)) {
            return $this->create()->with('success', 'Data berhasil di tambah! Silahkan tambahkan data baru');
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }

}
