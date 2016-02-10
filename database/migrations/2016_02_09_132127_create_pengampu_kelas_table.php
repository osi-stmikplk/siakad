<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengampuKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengampu_kelas', function (Blueprint $table) {
            // nilai MD5({id mata kuliah}{nomor induk dosen}{tahun ajaran}{kelas diampu})
            $table->char('id', 32)->primary();
            $table->string('tahun_ajaran', 5)->index();
            $table->date('tgl_penetapan')->nullable();
            $table->string('kelas', 5)->index();
            $table->tinyInteger('quota', false, true)->default(20);
            $table->tinyInteger('jumlah_peminat', false,true)->default(0);
            $table->tinyInteger('jumlah_pengambil', false,true)->default(0);
            // dosen id
            $table->string('dosen_id', 15)->nullable()->index();
            // mata kuliah id
            $table->string('mata_kuliah_id', 16)->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pengampu_kelas');
    }
}
