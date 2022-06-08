<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('fullname',255)->nullable(true);
            $table->dateTime('birth_date')->nullable(true);
            $table->string('gender',10)->nullable(true);
            $table->string('level',36)->nullable(true); // jenjang (Caberawit, praremaja, remaja, usia nikah)
            $table->string('class', 36)->nullable(true); // kelas
            $table->string('education',36)->nullable(true); // pendidikan (SD/MI, SMP, SMA/SMK, KULIAH, USMAN)
            $table->boolean('isPribumi')->nullable(true);
            $table->string('group',36);
            $table->string('village',36);
            $table->string('created_by',50);
            $table->string('updated_by',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
