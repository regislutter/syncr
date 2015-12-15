<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignchartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designcharts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('font_serif', 255)->nullable();
            $table->string('font_sans_serif', 255)->nullable();
            $table->string('background_color', 6)->nullable();
            $table->string('primary_color', 6)->nullable();
            $table->string('secondary_color', 6)->nullable();
            $table->string('info_color', 6)->nullable();
            $table->string('success_color', 6)->nullable();
            $table->string('warning_color', 6)->nullable();
            $table->string('alert_color', 6)->nullable();
            $table->tinyInteger('font_size')->nullable();
            $table->tinyInteger('line_height')->nullable();
            $table->string('title_h1_font', 255)->nullable();
            $table->string('title_h1_color', 6)->nullable();
            $table->tinyInteger('title_h1_font_size')->nullable();
            $table->tinyInteger('title_h1_line_height')->nullable();
            $table->string('title_h2_font', 255)->nullable();
            $table->string('title_h2_color', 6)->nullable();
            $table->tinyInteger('title_h2_font_size')->nullable();
            $table->tinyInteger('title_h2_line_height')->nullable();
            $table->string('title_h3_font', 255)->nullable();
            $table->string('title_h3_color', 6)->nullable();
            $table->tinyInteger('title_h3_font_size')->nullable();
            $table->tinyInteger('title_h3_line_height')->nullable();
            $table->string('title_h4_font', 255)->nullable();
            $table->string('title_h4_color', 6)->nullable();
            $table->tinyInteger('title_h4_font_size')->nullable();
            $table->tinyInteger('title_h4_line_height')->nullable();
            $table->string('title_h5_font', 255)->nullable();
            $table->string('title_h5_color', 6)->nullable();
            $table->tinyInteger('title_h5_font_size')->nullable();
            $table->tinyInteger('title_h5_line_height')->nullable();
            $table->string('title_h6_font', 255)->nullable();
            $table->string('title_h6_color', 6)->nullable();
            $table->tinyInteger('title_h6_font_size')->nullable();
            $table->tinyInteger('title_h6_line_height')->nullable();
            $table->string('text_font', 255)->nullable();
            $table->string('text_color', 6)->nullable();
            $table->tinyInteger('text_font_size')->nullable();
            $table->tinyInteger('text_line_height')->nullable();
            $table->smallInteger('breakpoint_mobile')->default(480)->unsigned();
            $table->smallInteger('breakpoint_tablet')->default(768)->unsigned();
            $table->smallInteger('breakpoint_desktop')->default(1024)->unsigned();
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
        Schema::drop('designcharts');
    }
}
