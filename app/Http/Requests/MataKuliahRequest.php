<?php

namespace Stmik\Http\Requests;

use Stmik\Http\Requests\Request;
use Stmik\MataKuliah;

class MataKuliahRequest extends Request
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
            'jurusan_id' => 'required|exists:jurusan,id',
            'kode' => 'required',
            'nama' => 'required',
            'sks' => 'required|numeric',
            'semester' => 'required|numeric'
        ];
    }

    /**
     * Pastikan kode mata kuliah adalah unique untuk satu jurusan.
     * @param string $kode mata kuliah
     * @return bool
     */
    public function kodeAdalahUniqueUntukJurusan($jurusanId, $kode)
    {
        return MataKuliah::whereKode($kode)->whereJurusanId($jurusanId)->count() <= 1;
    }
}
