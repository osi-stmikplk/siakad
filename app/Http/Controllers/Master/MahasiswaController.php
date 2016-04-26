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
use Stmik\Http\Requests\MasterMahasiswaRequest;

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

    /**
     * Tampilkan index
     * @return $this
     */
    public function index()
    {
        return view('master.mahasiswa.index')
            ->with('layout', $this->getLayout());
    }

    /**
     * Tampilkan form untuk proses update
     * @param $nim
     * @return mixed
     */
    public function edit($nim)
    {
        return view('master.mahasiswa.form')
            ->with('data', $this->factory->getDataMahasiswa($nim))
            ->with('action', route('master.mahasiswa.update', ['nim'=>$nim]));
    }

    /**
     * Lakukan proses terhadap inputan yang di post oleh user
     * @param $nim
     * @param MasterMahasiswaRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update($nim, MasterMahasiswaRequest $request)
    {
        $input = $request->all();
        if($this->factory->update($nim, $input)) {
            return $this->edit($nim)->with('success', "Data NIM {$this->factory->getLastInsertId()} telah terupdate!");
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }

    /**
     * Tampilkan form untuk mencatat mahasiswa baru
     * @return mixed
     */
    public function create()
    {
        return view('master.mahasiswa.form')
            ->with('data', null)
            ->with('action', route('master.mahasiswa.store'));
    }

    /**
     * Simpan data baru
     * @param MasterMahasiswaRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(MasterMahasiswaRequest $request)
    {
        $input = $request->all();
        if($this->factory->store($input)) {
            return $this->create()->with('success', "Data NIM {$this->factory->getLastInsertId()} telah ditambahkan, silahkan lakukan proses penambahan lainnya!");
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }

    public function delete($nim)
    {
        if($this->factory->delete($nim)) {
            return response("", 200,['X-IC-Remove'=>true]);
        }
        return response(json_encode($this->factory->getErrors()), 500,['X-IC-Remove'=>false]);
    }
}