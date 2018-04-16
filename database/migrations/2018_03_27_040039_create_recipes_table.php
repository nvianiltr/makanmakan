<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->mediumText('about')->nullable();
            $table->string('pictureURL')->nullable();
            $table->double('servingQty',7,2)->nullable();
            $table->enum('servingUnit', 
                ['person','people','serving','servings',
                'cup', 'cups', 'quart','quarts',
                'gallon','gallons','dozen',
                'liter','liters'])->nullable();
            $table->longText('preparation');
            $table->integer('qty')->nullable();
            $table->integer('price')->nullable();
            $table->dateTime('dateCreated');
            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('recipes');
    }
}
