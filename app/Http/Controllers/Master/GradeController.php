<?php
/**
 * Atur bagaimana master Grade di atur ...
 * User: toni
 * Date: 18/09/16
 * Time: 20:12
 */

namespace Stmik\Http\Controllers\Master;


use Panatau\Tools\IntercoolerTrait;
use Stmik\Factories\GradeFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;
use Stmik\Http\Requests\GradeRequest;

class GradeController extends Controller
{
    use GetDataBTTableTrait, IntercoolerTrait;

    protected $factory;

    public function __construct(GradeFactory $gradeFactory)
    {
        $this->factory = $gradeFactory;

        $this->middleware('auth.role:akma');
    }

    /**
     * Tampilkan index
     * @return $this
     */
    public function index()
    {
        return view('master.grade.index')
            ->with('layout', $this->getLayout());
    }

    /**
     * Tampilkan form untuk membuat baru
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('master.grade.form')
            ->with('data', null)
            ->with('action', route('master.grade.store'));
    }

    /**
     * Simpan hasil posting
     * @param GradeRequest $gradeRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(GradeRequest $gradeRequest)
    {
        if($this->factory->store($gradeRequest->except($this->intercoolerParams))) {
            return $this->create()->with('success', 'Data grade telah ditambahkan, silahkan tambah baru?');
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }

    /**
     * Tampilkan form untuk editing data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('master.grade.form')
            ->with('data', $this->factory->dapatkanData($id))
            ->with('action', route('master.grade.update', ['id'=>$id]));
    }

    /**
     * Simpan hasil posting terhadap editing
     * @param $id
     * @param GradeRequest $gradeRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update($id, GradeRequest $gradeRequest)
    {
        if($this->factory->update($id, $gradeRequest->except($this->intercoolerParams))) {
            return $this->edit($id)->with('success', 'Data grade telah diupdate!');
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }

    /**
     * Hapus
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function delete($id)
    {
        if($this->factory->delete($id)) {
            return response("", 200,['X-IC-Remove'=>true]);
        }
        return response(json_encode($this->factory->getErrors()), 500,['X-IC-Remove'=>false]);
    }
}