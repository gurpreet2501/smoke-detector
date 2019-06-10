<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewMotionDetectorStatusFieldInMachines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()  
    {
        Schema::table('sdetect_machines', function (Blueprint $table) {
            $table->boolean('motion_detector_status')->after('machine_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sdetect_machines', function (Blueprint $table) {
            //
        });
    }
}
