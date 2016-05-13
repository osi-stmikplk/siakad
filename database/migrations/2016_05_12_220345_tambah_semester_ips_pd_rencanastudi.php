<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahSemesterIpsPdRencanastudi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rencana_studi', function (Blueprint $table) {
            $table->decimal('ips', 4)->default(0);
            $table->tinyInteger('semester', false, true)->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rencana_studi', function (Blueprint $table) {
            $table->dropColumn(['ips', 'semester']);
        });
    }
}
