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
            // Untuk id adalah {jenjang: C atau E}{kode}
            $table->char('id', 7)->primary();
            $table->char('kode', 5)->index();
            $table->string('nama', 100);
            // yang ini adalah S1 atau D3 ...
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
