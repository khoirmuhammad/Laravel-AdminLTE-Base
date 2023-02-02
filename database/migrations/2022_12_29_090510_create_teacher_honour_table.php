<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherHonourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_honour', function (Blueprint $table) {
            $table->id();
            $table->uuid('teacher_id');
            $table->decimal('ontime_rate',18,2);
            $table->integer('late1_minutes');
            $table->decimal('late1_rate',18,2);
            $table->integer('late2_minutes');
            $table->decimal('late2_rate',18,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_honour');
    }
}
