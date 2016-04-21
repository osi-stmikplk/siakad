<?php

namespace Stmik\Http\Requests;

use Stmik\Http\Requests\Request;

class DosenKelasMKRequest extends Request
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
            'tahun_ajaran' => 'required|exists:referensi_akademik,tahun_ajaran',
            'kelas' => 'required',
            'quota' => 'required|numeric|min:20',
            'dosen_id' => 'required|exists:dosen,nomor_induk',
            'jurusan' => 'required|exists:jurusan,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id'
        ];
    }
}
