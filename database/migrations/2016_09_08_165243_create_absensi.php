<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rincian_studi', function (Blueprint $table) {
            $table->tinyInteger('absen_tanpa_keterangan', false, true)->default(0);
            $table->tinyInteger('absen_ijin', false, true)->default(0);
            $table->tinyInteger('absen_sakit', false, true)->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rincian_studi', function (Blueprint $table) {
            $table->dropColumn(['absen_tanpa_keterangan', 'absen_ijin', 'absen_sakit']);
        });
    }
}
