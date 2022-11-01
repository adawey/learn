<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->longText('interests')->nullable()->default(null);
            $table->string('occupation')->nullable()->default(null);
            $table->longText('about')->nullable()->default(null);
            $table->longText('fb_url')->nullable()->default(null);
            $table->longText('tw_url')->nullable()->default(null);
            $table->longText('website_url')->nullable()->default(null);
            $table->longText('profile_pic')->nullable()->default(null);
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
        Schema::dropIfExists('user_details');
    }
}
