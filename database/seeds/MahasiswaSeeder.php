<?php

use Illuminate\Database\Seeder;
use \Faker\Factory as Faker;

/**
 * Init untuk test data mahasiswa! Untuk ini adalah digunakan data dari Jurusan Informatika.
 * PASTIKAN UNTUK menjalankan ini setelah JurusanSeeder dijalankan terlebih dahulu!
 * Class MahasiswaSeeder
 */
class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i=0;$i<50;$i++) {
            $nomor_induk = ($i==1? 'CMHSTEST01': "CXX90909$i");
            DB::table('mahasiswa')->insert([
                'nama' => $faker->firstName .' '.$faker->lastName,
                'nomor_induk' => $nomor_induk,
                'tempat_lahir' => $faker->city,
                'tgl_lahir' => $faker->dateTimeBetween('-30 years', '-17 years')->format('Y-m-d'),
                'jenis_kelamin' => ($i %2 == 0? 'L':'P'),
                'alamat' => $faker->address,
                'tahun_masuk' => $faker->dateTimeBetween('-7 years', 'now')->format('Y'),
                'status' => \Stmik\Mahasiswa::STATUS_AKTIF,
                'status_awal_masuk' => \Stmik\Mahasiswa::AWAL_MASUK_BARU,
                'jurusan_id' => 'C55201'
            ]);
        }
    }
}
