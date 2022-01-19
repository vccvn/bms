<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->default(0);
            $table->integer('route_id')->default(0);
            $table->integer('type')->default(1); // 1 là xe khách - 2 là xe buyt
            $table->string('license_plate')->nullable();
            $table->string('license_plate_clean')->nullable();
            $table->text('description')->nullable();
            $table->string('phone_number')->nullable();
            $table->integer('seets')->default(4);
            $table->float('weight')->default(0);
            $table->integer('freq_days')->default(1);
            $table->integer('freq_trips')->default(1);
            $table->integer('date_limited')->nullable()->default(0);
            $table->integer('day_start')->nullable()->default(1);
            $table->integer('day_stop')->nullable()->default(31);
            $table->dateTime('lastest_run')->nullable();
            $table->integer('is_active')->default(0);
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
        Schema::dropIfExists('buses');
    }
}
