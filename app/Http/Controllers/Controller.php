<?php

namespace Stmik\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Panatau\Tools\IntercoolerTrait;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, IntercoolerTrait;


    /**
     * Set layout digunakan, tergantung dari jenis request.
     * @return string
     */
    protected function getLayout()
    {
        $c = 'layout.main';
        if(\Request::ajax())
        {
            $c = 'layout.ajax';
        }
        return $c;
    }
}
