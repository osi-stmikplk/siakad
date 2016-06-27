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
use Stmik\Http\Requests\DataDiriRequest;

class DataDiriController extends Controller
{

    /** @var DataDiriFactory */
    protected $factory;
    public function __construct(DataDiriFactory $factory)
    {
        $this->factory = $factory;

        $this->middleware('auth.role:mahasiswa');
    }

    /**
     * Tampilkan form untuk data diri dan update tentunya
     * @return $this
     */
    public function index()
    {
        $dataMahasiswa = $this->factory->getDataMahasiswa();
        return view('mahasiswa.data-diri.index')
            ->with('data', $dataMahasiswa)
            ->with('action', route('mhs.postDataDiri'))
            ->with('email', $this->factory->getDataEmailMahasiswa())
            ->with('layout', $this->getLayout());
    }

    /**
     * Simpan hasil posting data diri
     * @param DataDiriRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDataDiri(DataDiriRequest $request)
    {
        $this->authorize('postDataDiri', $this->factory->getDataMahasiswa());

        if($this->factory->updateDataDiri($request->except($this->getIntercoolerParams()))) {
            return response(""); // kembalikan tanpa isi saja!
        }
        return response()->json($this->factory->getErrorsString(), 500); // error ...
    }
}
