<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_id')->default(0);
            $table->integer('to_id')->default(0);
            $table->string('type')->default('direct');
            $table->string('name')->nullable();
            $table->integer('distance')->default(0);
            $table->integer('month_trips')->default(0);
            $table->integer('freq_days')->default(0);
            $table->integer('freq_trips')->default(0);
            $table->time('time_start')->default('00:00:00');
            $table->time('time_between')->default('00:30:00');
            $table->time('time_end')->default('23:59:00');
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
        Schema::dropIfExists('routes');
    }
}
