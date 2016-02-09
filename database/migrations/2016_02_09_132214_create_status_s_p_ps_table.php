<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusSPPsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_spp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mahasiswa_id', 12)->index();
            $table->string('tahun_ajaran', 5)->index();
            $table->tinyInteger('status', false, true)->default(0);
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
        Schema::drop('status_spp');
    }
}
