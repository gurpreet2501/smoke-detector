<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsToSdetectHomes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void 
     */
    public function up()
    {
         Schema::table('sdetect_homes', function($table) {
                $table->string('city',15)->after('address');
                $table->string('state',15)->after('city');
                $table->string('country',15)->after('state');
                $table->string('zip',15)->after('country');
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
