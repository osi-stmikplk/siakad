<?php
/**
 * Business roles untuk DataDiri Mahasiswa
 * User: toni
 * Date: 11/04/16
 * Time: 11:26
 */

namespace Stmik\Factories;


use Illuminate\Support\Arr;
use Stmik\Mahasiswa;

class DataDiriFactory extends MahasiswaFactory
{
    public function updateDataDiri($input, $nim=null)
    {
        try {
            \DB::transaction(function () use ($input, &$nim) {
                if($nim===null) {
                    $nim = \Auth::user()->name;
                }
                $m = Mahasiswa::with('user')->findOrFail($nim);
                $m->fill($input);
                $m->save();
                // sekarang simpan untuk pergantian email? dan ini disimpan di user bukan di mahasiswa. Ingat yah ... :D
                $mu = $m->user;
                $mu->email = $input['email'];
                $mu->save();
            });

        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['input'=>Arr::flatten($input)]);
            $this->errors->add('sys', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }
}