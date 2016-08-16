<?php

use Illuminate\Database\Seeder;

/**
 * Class ReferensiAkademikSeeder
 * Seeder untuk ReferensiAkademik
 */
class ReferensiAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // buat init untuk Referensi Akademik pada tahun ini dan semester ganjil
        $tgl = \Carbon\Carbon::create(null, 6, 1);
        $ta = $tgl->year . '1';
        // ambil dari pertengahan tahun
        $tglMulaiKrs = $tgl->format('d-m-Y'); // mulai tgl 1 bulan 6 tahun dibuat
        $tglAkhirKrs = $tgl->addDays(30)->format('d-m-Y'); // 30 hari isi KRS

        \Stmik\ReferensiAkademik::create([
            'tahun_ajaran' => $ta,
            'tgl_mulai_isi_krs' => $tglMulaiKrs,
            'tgl_berakhir_isi_krs' => $tglAkhirKrs
        ]);
    }
}
