<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_details', function (Blueprint $table) {
            $table->integer('recipe_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->primary(['recipe_id', 'tag_id']);
            $table->foreign('recipe_id')
                ->references('id')->on('recipes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('tag_id')
                ->references('id')->on('tag_headers')
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
        Schema::dropIfExists('tag_details');
    }
}
