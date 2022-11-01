<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->decimal('discount', 8, 2)->default(0);
            $table->string('discount')->default('0');
            $table->longText('description');
            // wheather this
            $table->mediumText('chapter_included')->nullable();
            $table->mediumText('process_group_included')->nullable();
            // or this , or both of them
            $table->string('exams')->nullable();

            $table->string('filter'); // chapter, process or chapter_process
            $table->string('contant_type'); // question, video
            $table->integer('active');
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
        Schema::dropIfExists('packages');
    }
}
