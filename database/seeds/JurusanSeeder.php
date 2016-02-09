<?php

use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Jurusan::create([
            'id' => 'G57601',
            'kode'=>'57601',
            'nama' => 'Manajemen Informatika',
            'jenjang' => 'G'
        ]);
        \App\Jurusan::create([
            'id' => 'C55201',
            'kode' => '55201',
            'nama' => 'Teknik Informatika',
            'jenjang' => 'C'
        ]);
        \App\Jurusan::create([
            'id' => 'C57201',
            'kode' => '57201',
            'nama' => 'Sistem Informasi',
            'jenjang' => 'C'
        ]);
        \App\Jurusan::create([
            'id' => 'E57401',
            'kode' => '57401',
            'nama' => 'Manajemen Informatika',
            'jenjang' => 'E'
        ]);
    }
}
