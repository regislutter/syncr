<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDeployedversionCopydeck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('copydecks', function (Blueprint $table) {
            $table->dropColumn(['development_file_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('copydecks', function (Blueprint $table) {
            $table->integer('development_file_id')->unsigned();
        });
    }
}
