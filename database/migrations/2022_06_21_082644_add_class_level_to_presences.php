<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClassLevelToPresences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->date('filled_date')->nullable(true)->change();
            $table->time('filled_time')->nullable(true);
            $table->string('class_level_id',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->dateTime('filled_date')->nullable(true)->change();
            $table->dropColumn('filled_time');
            $table->dropColumn('filled_time');
        });
    }
}
