<?php
/**
 * Mengatur bagaimana logic business dilaukan terhadap Referensi Akademik
 * User: toni
 * Date: 10/04/16
 * Time: 9:43
 */

namespace Stmik\Factories;

use Carbon\Carbon;
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
        $result = null;
        if(\App::environment() !== 'local') {
            // jangan dilakukan di local - saat pengembangan
            $result = \Cache::remember('tahun-ajaran-aktif', \Config::get('siakad.cache-diingat.lama'), function() {
                return ReferensiAkademik::orderBy('id', 'desc')->first();
            });
        } else {
            $result = ReferensiAkademik::orderBy('id', 'desc')->first();
        }
        return $result;
    }

    /**
     * Dapatkan daftar Tahun Ajaran
     * TODO: tambahkan cache untuk hasil query ini di production
     * @return mixed
     */
    public static function getTALists()
    {
        return ReferensiAkademik::pluck('tahun_ajaran', 'tahun_ajaran')->all();
    }

    /**
     * Check apakah pada hari ini yang aktif masih bisa mengisi FRS? TRUE bila masih dan sebaliknya bila sudah tidak
     * dalam periode pengisian FRS
     * @return bool
     */
    public static function hariIniMasihBisaIsiFRS()
    {
        $now = Carbon::now();
        $ta = self::getTAAktif(); // ambil TA aktif
        $periode = [
            'dari'=>Carbon::createFromFormat("d-m-Y", $ta->tgl_mulai_isi_krs),
            'sd' => Carbon::createFromFormat("d-m-Y H:i:s", $ta->tgl_berakhir_isi_krs . " 23:59:59")
        ];
        return $now->between($periode['dari'], $periode['sd']);
    }

}