<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionCenterDragdropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_center_dragdrops', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_id');
            $table->mediumText('correct_sentence');
            $table->mediumText('center_sentence');
            $table->mediumText('wrong_sentence');
            $table->timestamps();

            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_center_dragdrops');
    }
}
