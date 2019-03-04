<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValvesTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('sdetect_valves', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('machine_id')->unsigned();
            $table->boolean('alarm');
            $table->boolean('valve_status');
            $table->boolean('reset');
            $table->integer('user_id')->unsigned();
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
         Schema::dropIfExists('sdetect_valves');
    }
}
