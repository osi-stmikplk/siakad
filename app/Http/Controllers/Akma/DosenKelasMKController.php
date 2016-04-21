<?php
/**
 * Untuk mengatur bagaimana pembagian kelas untuk setiap matakuliah plus dengan dosennya!
 * User: toni
 * Date: 21/04/16
 * Time: 9:56
 */

namespace Stmik\Http\Controllers\Akma;


use Illuminate\Http\Request;
use Stmik\Factories\DosenKelasMKFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;
use Stmik\Http\Requests\DosenKelasMKRequest;

class DosenKelasMKController extends Controller
{

    use GetDataBTTableTrait;
    /** @var DosenKelasMKFactory */
    protected $factory;

    public function __construct(DosenKelasMKFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Kembalikan tampilan di bagian awal
     * @return $this
     */
    public function index()
    {
        return view('akma.dosen-kelas-mk.index')
            ->with('layout', $this->getLayout());
    }

    /**
     * Kembalikan form untuk entry data pengampu
     * @return mixed
     */
    public function create()
    {
        return view('akma.dosen-kelas-mk.form')
            ->with('data', null)
            ->with('action', route('akma.dkmk.store'));
    }

    /**
     * Proses hasil inputan untuk membuat data baru
     * @param DosenKelasMKRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(DosenKelasMKRequest $request)
    {
        if($this->factory->store($request->all())) {
            return $this->create()
                ->with('success', 'Berhasil Ditambahkan, silahkan tambahkan lagi data baru ...');
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }
}