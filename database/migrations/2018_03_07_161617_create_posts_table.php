<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('type')->default('post');
            $table->string('title');
            $table->string('slug');
            $table->string('keywords')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('feature_image')->nullable();
            $table->integer('views')->default(0);
            $table->integer('user_id')->unsigned()->default(0);
            $table->integer('parent_id')->unsigned()->default(0);
            $table->integer('cate_id')->unsigned()->default(0);
            $table->string('cate_map')->nullable();
            $table->integer('status')->default(200);
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
        Schema::dropIfExists('posts');
    }
}
