<?php

use Illuminate\Database\Seeder;

class OtorisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            \DB::transaction(function (){

                $roles = [
                    [
                        'name' => 'admin',
                        'label' => 'Untuk Admin'
                    ],
                    [
                        'name' => 'mahasiswa',
                        'label' => 'Untuk Mahasiswa'
                    ],
                    [
                        'name' => 'pegawai',
                        'label' => 'Untuk Pegawai'
                    ],
                    [
                        'name' => 'dosen',
                        'label' => 'Untuk Dosen'
                    ],
                    [
                        'name' => 'keuangan',
                        'label' => 'Untuk Keuangan'
                    ],
                ];
                foreach ($roles as $role) {
                    \Stmik\Otorisasi\Role::create($role);
                }

            });
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), []);
        }
    }
}
