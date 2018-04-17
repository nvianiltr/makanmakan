<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_details', function (Blueprint $table) {
            $table->integer('recipe_id')->unsigned();
            $table->integer('ingredient_id')->unsigned();
            $table->double('quantity', 7, 2);
            $table->enum('unit', ['g', 'grams', 'kg',
                'bottle', 'bottles', 'box', 'boxes',
                'can', 'cans', 'ounce', 'ounces', 'cup', 'cups',
                'gallon', 'gallons', 'dozen', 'dozens',
                'liter', 'liters', 'ml', 'milliliters',
                'pound', 'pounds', 'tablespoon', 'tablespoons', 'teaspoon', 'teaspoons'])->nullable();
            $table->primary(['recipe_id', 'ingredient_id']);
            $table->foreign('recipe_id')
                ->references('id')->on('recipes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('ingredient_id')
                ->references('id')->on('ingredients')
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
        Schema::dropIfExists('ingredient_details');
    }
}
