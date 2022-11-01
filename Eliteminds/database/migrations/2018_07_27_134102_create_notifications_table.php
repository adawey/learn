<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 
         * id,
         * [description],
         * [sight] -> defulat 0
         * [time]
         * 
         */
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('description');
            $table->integer('sight')->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
