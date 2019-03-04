<?php



use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;



class AddUserIdToAllTables extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

          Schema::table('sdetect_floors', function($table) {

                $table->integer('user_id')->after('home_id')->unsigned();

          });



          Schema::table('sdetect_homes', function($table) {

                $table->integer('user_id')->after('pin_code')->unsigned();

          });



          Schema::table('sdetect_rooms', function($table) {

                $table->integer('user_id')->after('home_id')->unsigned();

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

