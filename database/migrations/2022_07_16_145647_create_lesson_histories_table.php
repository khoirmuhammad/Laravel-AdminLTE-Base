<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_histories', function (Blueprint $table) {
            $table->id();
            $table->uuid('lesson_id');
            $table->float('percentage');
            $table->string('remark',500);
            $table->string('group',50);
            $table->integer('teacher_presence_id');
            $table->date('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_histories');
    }
}
