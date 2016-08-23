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
        return pakai_cache('tahun-ajaran-aktif', function() {
                return ReferensiAkademik::orderBy('id', 'desc')->first();
            });
    }

    /**
     * Dapatkan daftar Tahun Ajaran, penambahan $ranges untuk menambahkan pilihan terhadap range yang ingin ditampilkan.
     * $ranges adalah array yang nantinya dijadikan sebagai opsi pada render Tahun Ajaran. Bila tidak dimasukkan maka
     * yang dikembalikan nilainya adalah semua daftar Tahun Ajaran.
     * Untuk membuatnya maka jadikan indek sebagai opsi dan nilai indek sebagai isian.
     * Untuk pilihan indek dan nilainya:
     * - 'type' => 'persis' | 'range' | 'rangedex'
     * - 'nilai' => < nilai sesuai dengan type >
     * Bila type adalah persis maka indek Tahun Ajaran adalah harus persis sesuai dengan nilai yang dimasukkan di bagian
     * nilai. Misalnya:
     * [ 'type' => 'persis', 'nilai' => [ 20151, 20152 ] ]
     * berarti yang ditampilkan adalah Tahun Ajaran 20151 dan 20152.
     * Sedangkan bila:
     * [ 'type' => 'range', 'nilai' => [ 20111, 20151 ] ]
     * maka range adalah dari TA 20111 s/d 20151
     * [ 'type' => 'rangedex', 'nilai' => [ 0, 2 ]
     * maka range adalah offset ke 0 s/d 2 pada array Tahun Ajaran.
     * @param array $ranges
     * @return mixed
     */
    public static function getTALists(array $ranges = [])
    {
        $dta = pakai_cache('daftar-tahun-ajaran', function() {
            // tahun ajaran baru di bagian atas ...
            return ReferensiAkademik::orderBy('tahun_ajaran', 'desc')
                ->pluck('tahun_ajaran', 'tahun_ajaran')->all();
        });
        if(count($ranges)<=0) {
            return $dta;
        }
        $ret = [];
        $nilai = $ranges['nilai'];
        if($ranges['type']=='persis') {
            $ret = array_filter($dta, function($key) use($nilai) {
                return in_array($key, $nilai);
            });
        } elseif($ranges['type']=='range') {
            $ret = array_filter($dta, function($key) use($nilai) {
                return ($key >= $nilai[0] && $key <= $nilai[1]);
            });
        } elseif($ranges['type']=='rangedex') {
            $ret = array_slice($dta, $nilai[0], $nilai[1], true);
        }
        return $ret;
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

    /**
     * Dapatkan sisa hari dari hari ini sampai waktu berakhir pengisian FRS
     * @return int
     */
    public static function dapatkanSisaHariIsiFRS()
    {
        $now = Carbon::now();
        $ta = self::getTAAktif(); // ambil TA aktif
        $sd = Carbon::createFromFormat("d-m-Y H:i:s", $ta->tgl_berakhir_isi_krs . " 23:59:59");
        return $sd->diffInDays($now);
    }

}