<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePembimbingsTable
 * Perhatian ini adalah table many-to-many diantara Dosen dan Mahasiswa, dan secara laravel tidak dibutuhkan adanya
 * model untuk ini. Sehingga dalam hal tersebut, diputuskan untuk tidak mengikutsertakan model.
 */
class CreatePembimbingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembimbing', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mahasiswa_id', 12)->index();
            $table->string('dosen_id', 15)->index();
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
        Schema::drop('pembimbing');
    }
}
