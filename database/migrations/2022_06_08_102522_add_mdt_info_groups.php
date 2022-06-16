<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMdtInfoGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->boolean('is_mdt')->nullable(false);
            $table->string('mdt_statistic',50)->nullable(true);
            $table->string('mdt_principle',100)->nullable(true);
            $table->string('address',200)->nullable(true);
            $table->string('email',100)->nullable(true);
            $table->string('hp',200)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('is_mdt');
            $table->dropColumn('mdt_statistic');
            $table->dropColumn('mdt_principle');
            $table->dropColumn('address');
            $table->dropColumn('email');
            $table->dropColumn('hp');
        });
    }
}
