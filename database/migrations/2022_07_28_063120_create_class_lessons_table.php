<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_lessons', function (Blueprint $table) {
            $table->id();
            $table->string('class_level',50);
            $table->string('actual_semester',1);
            $table->string('lesson_class_id',50);
            $table->string('lesson_class_name',20);
            $table->string('lesson_class_semester',1);
            $table->boolean('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_lessons');
    }
}
