<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWrongAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wrong_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quiz_id');
            $table->integer('question_id');
            $table->longText('user_answer')->default(null)->nullable();
            $table->integer('flaged')->default(0);
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
        Schema::dropIfExists('wrong_answers');
    }
}
