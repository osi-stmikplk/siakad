<?php

namespace Stmik\Http\Requests;

use Illuminate\Support\Arr;
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
        $tamkiddosenid = implode(',', $this->only(['tahun_ajaran', 'mata_kuliah_id', 'dosen_id']));
        return [
            'tahun_ajaran' => 'required|exists:referensi_akademik,tahun_ajaran',
            'quota' => 'required|numeric|min:20',
            'dosen_id' => 'required|exists:dosen,nomor_induk',
            'jurusan' => 'required|exists:jurusan,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'kelas' => "required|dosen_boleh_ajar_kelas_mk:$tamkiddosenid"
        ];
    }
}
