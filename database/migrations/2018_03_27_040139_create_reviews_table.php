<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recipe_id')->unsigned();
            $table->integer('user_id')->unsigned(); // the one who leave a review
            $table->longText('content');
            $table->dateTime('datePosted');
            $table->boolean('isDeleted')->default(0);
            $table->foreign('user_id')
                  ->references('id')->on('users')
                    ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('recipe_id')
                  ->references('id')->on('recipes')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
