<?php

namespace Stmik\Http\Requests;

use Stmik\Http\Requests\Request;

class NilaiMahasiswaRequest extends Request
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
            'tugas.*' => 'numeric|min:0|max:100',
            'uts.*' => 'numeric|min:0|max:100',
            'praktikum.*' => 'numeric|min:0|max:100',
            'uas.*' => 'numeric|min:0|max:100',
            'akhir.*' => 'required|numeric|min:0|max:100',
        ];
    }
}
