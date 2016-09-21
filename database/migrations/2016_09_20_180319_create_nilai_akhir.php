<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiAkhir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rincian_studi', function (Blueprint $table) {
            // ada yang ketinggalan untuk pengisian nilai akhir
            // angka default 0
            $table->decimal('nilai_akhir', 5, 2)->default(0);
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
            $table->dropColumn('nilai_akhir');
        });
    }
}
