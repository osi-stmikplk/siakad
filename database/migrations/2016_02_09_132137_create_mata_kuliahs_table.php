<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMataKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_kuliah', function (Blueprint $table) {
            // memiliki format {kode jenjang}{kode program studi}{kode matakuliah}
            $table->string('id', 16)->primary();
            $table->string('kode', 20)->index();
            $table->string('nama');
            $table->tinyInteger('sks', false, false)->default(0);
            $table->tinyInteger('semester', false, false)->default(0);
            $table->string('status', 20)->index()->default('AKTIF');
            // jurusan
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
        Schema::drop('mata_kuliah');
    }
}
