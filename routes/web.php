<?php

use App\Models;
use Mailgun\Mailgun;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Libs\User;
use App\Libs\ZrApi;
use App\Libs\Notifications\Factory as Resp;

/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/



Route::get('/', function () {

    return view('welcome');

});


Route::get('/migrate', function () {
	Artisan::call('migrate');
	echo "Migration Hook Executed Successsfully.";
});


Route::post("/{version}", function ($version, Request $request) {

		$request->headers->set('Accept', 'application/json');
		$post = $request->all();
	
		$user_id = 0;
		
		if(isset($post['token'])){
			$user_id =  User::processToken($post['token']);
		}
		
		$class = "App\\Http\\REST\\".$post["object"]."\\".$post["api"];

		if(!class_exists($class))
			 return ZrApi::errorCode(114);

		$classobj= 'App\\Http\\REST\\'.ucfirst($post['object']).'\\'.ucfirst($post['api']);

		$obj = new $classobj;
		
		if(empty($post['data']))

			$post['data'] = [];	
	
		$user = Models\Users::where('id',$user_id)->first();
	
		if(!empty($user->role)){
			if($user->role == 'CUSTOMER'){
				if(!method_exists($obj, 'customer'))
						return ZrApi::errorCode(141);

				$resp =  $obj->customer($request,$user_id);
			}

			if($user->role == 'ADMIN'){
				 if(!method_exists($obj, 'admin'))
					return ZrApi::errorCode(141);

				$resp =  $obj->admin($request,$user_id);
			}
		}else{
			if(!method_exists($obj, 'guest'))
					return ZrApi::errorCode(141);

			$resp =  $obj->guest($request,$user_id=null);
		}
		
	
	return response()->json($resp,200);
	// return response()->json($resp);

});



Route::get("/{version}", function ($version, Request $request) {

		$post = $request->all();
		
		$user_id = 0;
		
		if(isset($post['data']['token'])){
			$user_id =  User::processToken($post['data']['token']);
			
		}
		
		$class = "App\\Http\\REST\\".$post["object"]."\\".$post["api"];

		if(!class_exists($class))
			 return Resp::errorCode(114);

		$classobj= 'App\\Http\\REST\\'.ucfirst($post['object']).'\\'.ucfirst($post['api']);

		$obj = new $classobj;
		
		if(empty($post['data']))

			$post['data'] = [];	
	
		$user = Models\Users::where('id',$user_id)->first();
	
		if(!empty($user->role)){
			if($user->role == 'CUSTOMER'){
				if(!method_exists($obj, 'customer'))
						return Resp::errorCode(141);

				$resp =  $obj->customer($request,$user_id);
			}

			if($user->role == 'ADMIN'){
				 if(!method_exists($obj, 'admin'))
					return Resp::errorCode(141);

				$resp =  $obj->admin($request,$user_id);
			}
		}else{
			if(!method_exists($obj, 'guest'))
					return Resp::errorCode(141);
 
			$resp =  $obj->guest($request,$user_id=null);
		}
		
			//If a person calls api that needs token. But token is absent. Then it will check for guest function.  But it will be absent 
		
		return response()->json($resp);
		// return ZrApi::json($resp);

});

