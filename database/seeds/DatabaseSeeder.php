<?php
/**
 * Lakukan insialisasi data!
 */
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!$this->command->confirm("Yakin untuk melakukan migrasi?")) {
            $this->command->info("Proses dibatalkan!");
            exit();
        }
        try {
            \DB::transaction(function () {
                $this->call(ReferensiAkademikSeeder::class);
                $this->call(OtorisasiSeeder::class);
                $this->call(JurusanSeeder::class);
                $this->call(PegawaiSeeder::class);
                $this->call(MahasiswaSeeder::class);
                $this->call(UsersSeeder::class);
            });

        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), []);
            $this->command->error("Error data di rollback: " .$e->getMessage());
        }
    }
}
