<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMOtionDetectorsTblMigSecond extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sdetect_motion_detectors', function (Blueprint $table) {
            $table->string('machine_id');
            $table->dropColumn('user_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sdetect_motion_detectors', function (Blueprint $table) {
            //
        });
    }
}
