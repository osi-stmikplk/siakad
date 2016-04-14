<?php
/**
 * Di load pertamakali untuk melakukan berbagai proses terkait dengan tampilan
 * User: toni
 * Date: 09/04/16
 * Time: 10:26
 */

namespace Stmik\Http\Controllers;


class SiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Load default!
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('site.index')
            ->with('layout', $this->getLayout());
    }

}