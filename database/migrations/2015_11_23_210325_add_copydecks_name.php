<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCopydecksName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('copydecks', function (Blueprint $table) {
            $table->string('name')->default('old copydeck');
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
            $table->dropColumn('name');
        });
    }
}
