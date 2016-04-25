<?php

namespace Stmik\Http\Requests;

use Stmik\Http\Requests\Request;

class MasterMahasiswaRequest extends Request
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
     * TODO: tambahkan validasi untuk unique nim dan juga untuk format nya ...
     * @return array
     */
    public function rules()
    {
        return [
            'nama' => 'required',
            'jurusan_id' => 'required|exists:jurusan,id',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' =>'required',
            'alamat' => 'required',
            'agama' => 'required',
            'tahun_masuk' => 'required|numeric',
            'status' => 'required',
            'status_awal_masuk' => 'required'
        ];
    }
}
