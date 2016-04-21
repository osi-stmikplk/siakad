<?php
/**
 * Punya Dosen
 * User: toni
 * Date: 21/04/16
 * Time: 12:06
 */

namespace Stmik\Factories;


use Stmik\Dosen;

class DosenFactory extends AbstractFactory
{

    /**
     * Kembalikan lists untuk dosen
     * @return mixed
     */
    public static function getDosenLists()
    {
        return Dosen::pluck('nama', 'nomor_induk')->all();
    }
}