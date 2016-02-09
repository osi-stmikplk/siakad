<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJurusansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurusan', function (Blueprint $table) {
            // Untuk id adalah {jenjang}{kode}
            $table->char('id', 7)->primary();
            $table->char('kode', 5)->unique()->index();
            $table->string('nama', 100);
            $table->char('jenjang', 2)->index();
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
        Schema::drop('jurusan');
    }
}
