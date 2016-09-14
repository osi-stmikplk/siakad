<?php

namespace Stmik\Http\Requests;

use Stmik\Http\Requests\Request;

class InputAbsenRequest extends Request
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
            'mhs.*' => 'numeric',
            'ket.*' => 'in:H,I,S,TK'
        ];
    }
}
