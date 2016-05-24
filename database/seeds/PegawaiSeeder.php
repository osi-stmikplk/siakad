<?php

use Illuminate\Database\Seeder;

/**
 * Buat admin saja untuk pegawai di awalnya ini
 * Class PegawaiSeeder
 */
class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pegawai')->insert([
            'nomor_induk' => 'PEGADMIN',
            'nama' => 'Admin',
            'alamat' => 'Somewhere in the jungle',
            'email' => str_random(10) .'@somemail.co.id'
        ]);
    }
}
