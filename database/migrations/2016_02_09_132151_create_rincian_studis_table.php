<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRincianStudisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rincian_studi', function (Blueprint $table) {
            // md5 dari {id PengampuKelas}{nim}
            $table->char('id', 32)->primary();
            // ini link ke PengampuKelas
            $table->char('kelas_diambil_id', 32)->index();
            $table->tinyInteger('jumlah_kehadiran', false, true)->default(0);
            $table->decimal('nilai_tugas', 5, 2)->default(0);
            $table->decimal('nilai_uts', 5, 2)->default(0);
            $table->decimal('nilai_praktikum', 5, 2)->default(0);
            $table->decimal('nilai_uas', 5, 2)->default(0);
            // huruf default E :D
            $table->string('nilai_huruf', 3)->default('E');
            // angka default 0
            $table->decimal('nilai_angka', 5, 2)->default(0);
            // status TIDAK LULUS
            $table->string('status_lulus', 15)->default('TIDAK LULUS')->index();
            // link ke rencana studi
            $table->string('rencana_studi_id', 17)->index();

//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rincian_studi');
    }
}
