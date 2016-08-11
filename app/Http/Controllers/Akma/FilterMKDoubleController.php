<?php

namespace Stmik\Http\Controllers\Akma;

use Illuminate\Http\Request;

use Stmik\Factories\FilterMKDoubleFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;
use Stmik\Http\Requests;

class FilterMKDoubleController extends Controller
{
    use GetDataBTTableTrait;
    /** @var FilterMKDoubleFactory  */
    protected $factory;

    public function __construct(FilterMKDoubleFactory $filterMKDoubleFactory)
    {
        $this->factory = $filterMKDoubleFactory;

        $this->middleware('auth.role:akma');

    }

    /**
     * @return $this
     */
    public function index()
    {
        return view('akma.filter-mk-double.index')
            ->with('layout', $this->getLayout());
    }

    /**
     * Lakukan setting status ditampilkan atau tidak pada MK yang nantinya akan diproses sebagai bagian dari transkrip
     * nilai akhir mahasiswa yang diperhitungkan sebagai IPK. Issue #29
     * @param $idRincianStudi
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function postStatus($idRincianStudi)
    {
        if($this->factory->setStatus($idRincianStudi)) {
            // lakukan trigger pada client
            $triggerini['padaSetelahReset'] = [$idRincianStudi, $this->factory->getLastRincianStudiStatus()];
            return response("",200,
                ['X-IC-Trigger' => json_encode($triggerini) ]);
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }
}
