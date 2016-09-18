<?php

namespace Stmik\Http\Requests;

use Stmik\Http\Requests\Request;

class GradeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "tahun_ajaran_mulai"=>"required|max:5",
            "tahun_ajaran_berakhir"=>"required|max:5",
            "minimal_a"=>"required|numeric",
            "minimal_ab"=>"required|numeric",
            "minimal_b"=>"required|numeric",
            "minimal_bc"=>"required|numeric",
            "minimal_c"=>"required|numeric",
            "minimal_d"=>"required|numeric",
            "minimal_e"=>"required|numeric",
            "angka_a"=>"required|numeric",
            "angka_ab"=>"required|numeric",
            "angka_b"=>"required|numeric",
            "angka_bc"=>"required|numeric",
            "angka_c"=>"required|numeric",
            "angka_d"=>"required|numeric",
            "angka_e"=>"required|numeric"
        ];
    }
}
