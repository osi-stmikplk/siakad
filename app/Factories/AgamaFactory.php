<?php
/**
 * Pengaturan tentang agama disini
 * User: toni
 * Date: 25/04/16
 * Time: 20:49
 */

namespace Stmik\Factories;


class AgamaFactory extends AbstractFactory
{

    public static function getAgamaLists()
    {
        return [
            'ISLAM' => 'ISLAM',
            'KATOLIK' => 'KATOLIK',
            'KRISTEN' => 'KRISTEN',
            'HINDU' => 'HINDU',
            'BUDHA' => 'BUDHA',
            'KAHARINGAN' => 'KAHARINGAN',
            'LAINNYA' => 'LAINNYA'
        ];
    }
}