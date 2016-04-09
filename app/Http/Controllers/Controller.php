<?php

namespace Stmik\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


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


    /**
     * Fungsi untuk membantu proses paging menggunakan table bootstrap
     * @return array ['limit', 'offset', 'sort', 'order', 'search']
     * https://gist.github.com/mikepenz/06df1204cbb65b874cb5
     */
    protected function pagingTableBootstrap()
    {
        // set limit
        $limit = \Request::get('limit', 25);
        // set offset
        $offset = \Request::get('offset',0);
        // sorting
        $sort = \Request::get('sort', '');
        // order
        $order = \Request::get('order', 'desc');
        // doing some search?
        $search = \Request::get('search', '');
        // other input query?
        $otherQuery = \Request::except(['limit', 'offset', 'sort', 'order', 'search']);

        return compact('limit', 'offset', 'sort', 'order', 'search', 'otherQuery');
    }
}
