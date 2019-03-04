<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMachines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sdetect_machines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('serial_no');
            $table->boolean('carbon_monoxide');
            $table->boolean('lpg');
            $table->boolean('smoke');
            $table->integer('air_purity');
            $table->integer('temperature');
            $table->integer('humidity');
            $table->unsignedInteger('home_id')->nullable();
            $table->unsignedInteger('floor_id')->nullable();
            $table->unsignedInteger('room_id')->nullable();
            $table->foreign('floor_id')->references('id')->on('sdetect_floors');
            $table->foreign('room_id')->references('id')->on('sdetect_rooms');
            $table->foreign('home_id')->references('id')->on('sdetect_homes');
            $table->unsignedInteger('user_id');
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
        //
    }
}
