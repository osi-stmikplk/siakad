<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRencanaStudisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rencana_studi', function (Blueprint $table) {
            // { tahun ajaran }{ nim }
            $table->string('id', 17)->primary();
            $table->string('tahun_ajaran', 5)->index();
            // nomor induk punya mahasiswa
            $table->string('mahasiswa_id', 12)->index();
            $table->date('tgl_pengisian')->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->string('status', 15)->index();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rencana_studi');
    }
}
