<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vessels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mmsi')->nullable();
            $table->integer('status')->nullable();
            $table->integer('stationId')->nullable();
            $table->integer('speed')->nullable();
            $table->float('lat')->nullable();
            $table->float('lon')->nullable();
            $table->integer('course')->nullable();
            $table->integer('heading')->nullable();
            $table->string('rot')->nullable();
            $table->integer('timestamp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vessels');
    }
}
