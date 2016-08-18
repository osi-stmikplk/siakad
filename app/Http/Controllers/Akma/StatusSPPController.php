<?php
/**
 * Created by PhpStorm.
 * User: toni
 * Date: 10/04/16
 * Time: 10:04
 */

namespace Stmik\Http\Controllers\Akma;


use Illuminate\Http\Request;
use Stmik\Factories\ReferensiAkademikFactory;
use Stmik\Factories\StatusSPPFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;
use Stmik\Http\Requests\StatusSPPRequest;

class StatusSPPController extends Controller
{
    use GetDataBTTableTrait;

    /** @var StatusSPPFactory */
    protected $factory;
    public function __construct(StatusSPPFactory $statusSPPFactory)
    {
        $this->factory = $statusSPPFactory;

        $this->middleware('auth.role:akma|keuangan');
    }

    /**
     * Tampilkan halaman index
     * @return $this
     */
    public function index()
    {
        return view('akma.status-spp.index')
            ->with('layout', $this->getLayout());
    }

    /**
     * Karena request ternyata hanya melakukan proses terhadap form value maka lakukan merge dahulu baru panggil secara
     * manual proses validate.
     * @param $nim
     * @param $ta
     * @param Request $request
     */
    protected function validateSelf($nim, $ta, Request $request)
    {
        $request->merge(['nim'=>$nim, 'ta'=>$ta]);
        $this->validate($request, [
            'nim' => 'required|exists:mahasiswa,nomor_induk',
            'ta'  => 'required|exists:referensi_akademik,tahun_ajaran'
        ]);
    }

    /**
     * Set status pembayaran
     * @param $nim
     * @param $ta
     * @param StatusSPPRequest $request
     */
    public function setStatus($nim, $ta, Request $request)
    {
        $this->validateSelf($nim, $ta, $request);
        // disini pasti sudah beres proses validasinya, maka lakukan penyimpanan
        if($this->factory->setStatusNya($nim, $ta)) {
            // bila berhasil kembalikan render
            return view('akma.status-spp._btn-aksi')
                ->with('nim', $nim)
                ->with('ta', $ta)
                ->with('aksiLunasi', ! $this->factory->getStatusTerakhirDiInsert());
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }
}
