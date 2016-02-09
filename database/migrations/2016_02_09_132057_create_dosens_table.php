<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen', function (Blueprint $table) {
//            $table->string('id', 15)->primary();
            $table->string('nomor_induk', 15)->primary();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->char('jenis_kelamin', 1)->index();
            // TODO: Apa ini untuk jenis?
            $table->char('jenis', 1)->index()->nullable();
            $table->text('alamat')->nullable();
            $table->string('hp', 50)->nullable();
            $table->string('nidn', 50)->nullable()->index();
            $table->string('agama', 50)->nullable()->index();
            $table->string('status', 15)->default('LUAR BIASA')->index();
            $table->char('status_aktif')->default('A')->index();
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
        Schema::drop('dosen');
    }
}
