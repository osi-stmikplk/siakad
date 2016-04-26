<?php
/**
 * Todos Controller
 * User: toni
 * Date: 22/11/15
 * Time: 16:25
 */

namespace Panatau\Todos\Http\Controllers;

use Illuminate\Routing\Controller;
use Panatau\Todos\Todos;

class TodosController extends Controller
{
    public function getTodos()
    {
        return Todos::all()->toJson();
    }

    public function postStore()
    {
        $input = \Input::only(['judul', 'keterangan']);
        $input['status'] = 0;
        $c = Todos::create($input);
        return $c->toJson();
    }

    public function postUpdate($id)
    {
        $input = \Input::only(['judul', 'keterangan', 'status']);
        $c = Todos::find($id);
        $c->fill($input);
        if($c->save())
        {
            return $c->toJson();
        }
    }

    public function postSetStatus($id,$status)
    {
        $c = Todos::find($id);
        $c->status = $status;
        if($c->save())
        {
            return $c->toJson();
        }
    }
}