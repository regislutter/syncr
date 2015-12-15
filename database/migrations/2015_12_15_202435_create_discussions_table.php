<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->boolean('sticky')->default(false);
            $table->boolean('important')->default(false);
            $table->tinyInteger('copydeck_id')->unsigned()->nullable();
            $table->tinyInteger('project_id')->unsigned()->nullable();
            $table->tinyInteger('user_id')->unsigned();
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
        Schema::drop('discussions');
    }
}
