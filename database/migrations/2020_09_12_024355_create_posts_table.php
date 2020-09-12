<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->uuid('pid');
            $table->string('title', 100);
            $table->string('cover')->nullable();
            $table->string('description')->nullable();
            $table->string('url');
            $table->string('status')->default('pending');

            $table->longText('content');
            $table->longText('delta_content');
            $table->text('medias')->default('[]');
            $table->text('answer_list')->default('[]');
            $table->string('type');

            $table->integer('author')->unsigned();
            $table->integer('category')->unsigned();

            $table->integer('nums_pocket')->unsigned();
            $table->integer('nums_good')->unsigned();
            $table->integer('nums_bad')->unsigned();
            $table->integer('nums_share')->unsigned();
            $table->integer('nums_comment')->unsigned();

            $table->timestamps();

            $table->foreign('category')->references('id')->on('categories');
            $table->foreign('author')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
