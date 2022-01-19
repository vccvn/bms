<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlFramesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_frames', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('url');
            $table->string('avatar')->nullable();
            $table->text('style')->nullable();
            $table->string('attr_image')->nullable();
            $table->string('title');
            $table->string('attr_title')->nullable();
            $table->string('description')->nullable();
            $table->string('attr_description')->nullable();
            $table->text('content');
            $table->string('tag')->nullable();
            $table->string('attr_tag')->nullable();
            $table->string('except')->nullable();
            $table->string('slug')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->integer('index')->default(10);
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
        Schema::dropIfExists('crawl_frames');
    }
}
