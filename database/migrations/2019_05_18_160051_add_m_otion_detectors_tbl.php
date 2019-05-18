<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMOtionDetectorsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sdetect_motion_detectors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('serial');
            $table->integer('name');
            $table->integer('motion_detector_status');
            $table->integer('motion_detector_button_status');
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
        Schema::dropIfExists('sdetect_motion_detectors');
    }
}
