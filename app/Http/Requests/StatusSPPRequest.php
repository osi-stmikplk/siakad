<?php

namespace Stmik\Http\Requests;

use Stmik\Http\Requests\Request;

class StatusSPPRequest extends Request
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
            'nim' => 'required|exists:mahasiswa,nomor_induk',
            'ta'  => 'required|exists:referensi_akademik,tahun_ajaran'
        ];
    }
}
