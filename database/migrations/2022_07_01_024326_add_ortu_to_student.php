<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrtuToStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('parent',250)->nullable(true);
            $table->string('parent_phone', 50)->nullable(true);
            $table->string('address_source', 250)->nullable();
            $table->boolean('is_accel')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('parent');
            $table->dropColumn('parent_phone');
            $table->dropColumn('address_source');
            $table->dropColumn('is_accel');
        });
    }
}
