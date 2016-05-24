<?php

use Illuminate\Database\Seeder;

/**
 * Bikin users supaya bisa di test
 * userid admin untuk admin dan userid CMHSTEST01 untuk mahasiswa, semua menggunakan password rahasia
 * Class UsersSeeder
 */
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ambil pegawai dan buat usernya
        /** @var \Stmik\Pegawai $peg */
        $peg = \Stmik\Pegawai::where('nomor_induk', '=', 'PEGADMIN')->first();
        // buat user
        $user = new \Stmik\User();
        $user->name = 'admin';
        $user->email = $peg->email;
        $user->password = Hash::make('rahasia');
        $peg->user()->save($user);
        $user->assignRole('admin');
        /** @var \Stmik\Mahasiswa $mhs */
        $mhs = \Stmik\Mahasiswa::where('nomor_induk', '=', 'CMHSTEST01')->first();
        // buat user
        $user = new \Stmik\User();
        $user->name = $mhs->nomor_induk;
        $user->email = str_random(5) . '@fakemail.co.id';
        $user->password = Hash::make('rahasia');
        $mhs->user()->save($user);
        $user->assignRole('mahasiswa');
    }
}
