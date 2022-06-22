<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresenceTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presence_teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('teacher_id',50);
            $table->string('class_level_id',50);
            $table->date('clock_in_date')->nullable(true);
            $table->date('clock_out_date')->nullable(true);
            $table->time('clock_in_time')->nullable(true);
            $table->time('clock_out_time')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presence_teachers');
    }
}
