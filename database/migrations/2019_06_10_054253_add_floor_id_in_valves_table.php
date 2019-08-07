<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFloorIdInValvesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sdetect_valves', function (Blueprint $table) {
            $table->integer('floor_id')->after('machine_id');
            $table->integer('home_id')->after('machine_id');
            $table->string('serial_id',100)->after('machine_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sdetect_valves', function (Blueprint $table) {
            //
        });
    }
}
