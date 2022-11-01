<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('buyerID');
            $table->string('paymentID');
            $table->string('cartID');
            $table->string('totalPaid');
            $table->string('paypalEmail');
            $table->string('city');
            $table->string('state');
            $table->string('postalCode');
            $table->string('countryCode');
            $table->string('address');
            $table->string('paymentMethod');
            $table->integer('complete')->default(1);
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
        Schema::dropIfExists('payments');
    }
}
