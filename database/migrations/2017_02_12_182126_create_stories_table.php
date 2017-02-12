<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('abstract');
            $table->string('section');
            $table->string('url');
            $table->dateTimeTz('created_date');
            $table->string('subsection')->nullable();
            $table->string('short_url')->nullable();
            $table->string('byline')->nullable();
            $table->dateTimeTz('updated_date')->nullable();
            $table->dateTimeTz('published_date')->nullable();

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
        Schema::dropIfExists('stories');
    }
}
