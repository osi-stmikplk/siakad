<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nomor_induk', 12)->primary();
            $table->string('nama', 100)->index();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->char('jenis_kelamin', 1)->index();
            $table->text('alamat')->nullable();
            $table->string('hp', 50)->nullable();
            $table->string('agama', 50)->nullable()->index();
            $table->integer('tahun_masuk', false, true)->index();
            $table->char('status', 1)->index();
            $table->char('status_awal_masuk', 1)->index();
            $table->char('jurusan_id', 7)->nullable()->index();
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
        Schema::drop('mahasiswa');
    }
}
