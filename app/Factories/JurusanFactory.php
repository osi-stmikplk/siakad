<?php
/**
 * Atur jurusan
 * User: toni
 * Date: 10/04/16
 * Time: 15:42
 */

namespace Stmik\Factories;


use Stmik\Jurusan;

class JurusanFactory extends AbstractFactory
{

    /**
     * Dapatkan daftar jurusan, mengembalikan berupa array dengan key adalah id jurusan dan nilainya adalah nama jurusan
     * lengkap
     * @return array
     */
    public static function getJurusanLists()
    {
        $s = Jurusan::all();
        $a = [];
        foreach ($s as $j) {
            $a[$j->id] = $j->jenjang .' '. $j->nama;
        }
        return $a;
    }

}