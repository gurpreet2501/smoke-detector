<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAndDropColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sdetect_motion_detectors', function (Blueprint $table) {
            $table->dropColumn('motion_detector_button_status');
            $table->renameColumn('motion_detector_status','status');

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
