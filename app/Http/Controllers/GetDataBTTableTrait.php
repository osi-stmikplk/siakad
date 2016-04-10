<?php
/**
 * Trait untuk function meload data bootstrap table
 * User: toni
 * Date: 10/04/16
 * Time: 10:20
 */

namespace Stmik\Http\Controllers;


use Illuminate\Http\Request;

/**
 * Ini adalah utility trait agar mempermudah dalam mempergunakan Bootstrap Table.
 * Class GetDataBTTableTrait
 * @package Stmik\Http\Controllers
 */
trait GetDataBTTableTrait
{
    /**
     * Fungsi untuk membantu proses paging menggunakan table bootstrap
     * @return array ['limit', 'offset', 'sort', 'order', 'search']
     * https://gist.github.com/mikepenz/06df1204cbb65b874cb5
     */
    protected function pagingTableBootstrap(Request $request)
    {
        // set limit
        $limit = $request->get('limit', 25);
        // set offset
        $offset = $request->get('offset',0);
        // sorting
        $sort = $request->get('sort', '');
        // order
        $order = $request->get('order', 'desc');
        // doing some search?
        $search = $request->get('search', '');
        // other input query?
        $otherQuery = $request->except(['limit', 'offset', 'sort', 'order', 'search']);

        return compact('limit', 'offset', 'sort', 'order', 'search', 'otherQuery');
    }

    /**
     * kembalikan data yang akan digunakan oleh BootstrapTable
     * @return mixed
     */
    public function getDataBtTable(Request $request)
    {
        if(!$this->factory) throw new  \Exception('getDataBTTable membutuhkan factory::getBTTable yang tidak di buat!');
        return $this->factory->getBTTable($this->pagingTableBootstrap($request), $request);
    }
}