<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tahun_ajaran_mulai', 5)->index();
            $table->string('tahun_ajaran_berakhir', 5)->index();
            $table->decimal('minimal_a', 5,2)->default(-1);
            $table->decimal('minimal_ab', 5,2)->default(-1);
            $table->decimal('minimal_b', 5,2)->default(-1);
            $table->decimal('minimal_bc', 5,2)->default(-1);
            $table->decimal('minimal_c', 5,2)->default(-1);
            $table->decimal('minimal_d', 5,2)->default(-1);
            $table->decimal('minimal_e', 5,2)->default(0);
            /**
             * Nilai angka
             */
            $table->decimal('angka_a', 3, 2)->default(4);
            $table->decimal('angka_ab', 3, 2)->default(3.5);
            $table->decimal('angka_b', 3, 2)->default(3);
            $table->decimal('angka_bc', 3, 2)->default(2.5);
            $table->decimal('angka_c', 3, 2)->default(2);
            $table->decimal('angka_d', 3, 2)->default(1);
            $table->decimal('angka_e', 3, 2)->default(0);

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
        Schema::drop('grade');
    }
}
