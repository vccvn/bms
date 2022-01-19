<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dynamic_id')->default(0);
            $table->integer('frame_id');
            $table->integer('quantity')->default(0);
            $table->integer('user_id')->nullable();
            $table->integer('cate_id')->nullable();
            $table->integer('run_time')->default(0);
            $table->string('url')->nullable();
            $table->string('url_post')->nullable();
            $table->string('repeat_time')->default('00:05:00');
            $table->string('crawl_time')->default('06:00:00');
            $table->dateTime('datetime_crawl')->nullable();
            $table->string('crawl_last_time')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('crawl_tasks');
    }
}
