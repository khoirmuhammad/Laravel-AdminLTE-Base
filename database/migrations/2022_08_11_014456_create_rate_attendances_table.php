<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_attendances', function (Blueprint $table) {
            $table->uuid('teacher_id')->primary();
            $table->decimal('rate_on_time', 9, 2);
            $table->decimal('rate_late', 9, 2);
            $table->tinyInteger('max_attendance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rate_attendances');
    }
}
