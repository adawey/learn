<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('title');            
            $table->longText('description');
            $table->integer('chapter');
            $table->integer('project_management_group')->nullable();
            $table->integer('process_group')->nullable();
            $table->string('exam_num')->nullable();
            $table->mediumText('video_url');
            $table->mediumText('attachment_url');
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
        Schema::dropIfExists('videos');
    }
}
