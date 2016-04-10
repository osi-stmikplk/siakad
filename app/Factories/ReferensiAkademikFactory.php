<?php
/**
 * Mengatur bagaimana logic business dilaukan terhadap Referensi Akademik
 * User: toni
 * Date: 10/04/16
 * Time: 9:43
 */

namespace Stmik\Factories;

use Stmik\ReferensiAkademik;

class ReferensiAkademikFactory extends AbstractFactory
{
    /**
     * Dapatkan Tahun Ajaran yang aktif saat ini. Tahun Ajaran yang aktif sendiri adalah record terakhir yang di urut
     * berdasarkan id
     * @return mixed
     */
    public static function getTAAktif()
    {
        return ReferensiAkademik::orderBy('id', 'desc')->first();
    }

    /**
     * Dapatkan daftar Tahun Ajaran
     * @return mixed
     */
    public static function getTALists()
    {
        return ReferensiAkademik::pluck('tahun_ajaran', 'tahun_ajaran')->all();
    }

}