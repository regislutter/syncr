<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableTicketUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->smallInteger('user_id')->tinyInteger('user_id')->unsigned()->nullable()->change(); // SmallInteger -> TinyInteger : bug in Doctrine when changing tinyInteger column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->smallInteger('user_id')->tinyInteger('user_id')->unsigned()->change();
        });
    }
}
