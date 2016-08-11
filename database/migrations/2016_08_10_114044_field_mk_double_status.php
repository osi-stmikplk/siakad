<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FieldMkDoubleStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rincian_studi', function (Blueprint $table) {
            $table->tinyInteger('tampil_di_transkrip', false, true)->index()->default(1);
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
            $table->dropColumn('tampil_di_transkrip');
        });
    }
}
