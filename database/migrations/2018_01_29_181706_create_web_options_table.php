<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->default('text');
            $table->string('option_group')->default('siteinfo');
            $table->string('name');
            $table->text('value')->nullable();
            $table->string('label')->nullable();
            $table->string('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_options');
    }
}
