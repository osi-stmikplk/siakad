<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferensiAkademiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referensi_akademik', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tahun_ajaran', 5)->index();
            $table->date('tgl_mulai_isi_krs');
            $table->date('tgl_berakhir_isi_krs');
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
        Schema::drop('referensi_akademik');
    }
}
