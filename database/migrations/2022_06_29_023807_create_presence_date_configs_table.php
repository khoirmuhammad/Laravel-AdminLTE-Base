<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresenceDateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presence_date_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('group');
            $table->uuid('village');
            $table->string('level',50);
            $table->string('class_level',50);
            $table->string('day',10);
            $table->time('start_time');
            $table->time('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presence_date_configs');
    }
}
