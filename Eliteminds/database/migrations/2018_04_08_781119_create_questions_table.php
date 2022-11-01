<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('title');
            $table->longText('a');
            $table->longText('b');
            $table->longText('c');
            $table->longText('correct_answer');
            $table->longText('feedback');
            $table->integer('chapter');
            $table->integer('project_management_group')->nullable();
            $table->integer('process_group')->nullable();
            $table->string('exam_num')->nullable();
            $table->mediumText('img')->nullable();
            $table->tinyInteger('demo')->default(0);
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
        Schema::dropIfExists('questions');
    }
}
