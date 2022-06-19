<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderIsStudentToTeacher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Teachers', function (Blueprint $table) {
            $table->string('gender',20);
            $table->boolean('is_student');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Teachers', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('is_student');
        });
    }
}
