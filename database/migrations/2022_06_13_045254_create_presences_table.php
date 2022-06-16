<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_id', 50);
            $table->boolean('is_present')->nullable(true);
            $table->boolean('is_permit')->nullable(true);
            $table->boolean('is_absent')->nullable(true);
            $table->string('permit_desc', 200)->nullable(true);
            $table->dateTime('filled_date')->nullable(true);
            $table->string('filled_by',50);
            $table->string('group_id', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presences');
    }
}
