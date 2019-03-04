<?php 
namespace App\Libs; 
use App\Models;
use App\Libs\Notifications\Factory as Resp;
use Illuminate\Support\Facades\Hash;
/**
* 
*/
class User
{
	
	function __construct()
	{
		
	}

	public static function generateToken($user_id){
		$token = '';
		// $hash = Hash::make(time().rand(1,10000).rand(1,10000));
		$exists = 1;
		while($exists)
			{
			  	$hash = self::generate_hash();
			  	$hash = self::removeSpecialChars($hash);
			  
			 	if(self::check_if_hash_exists($hash)){
			  	   continue;
			 	}
			 	$exists = false;
		}

		$obj = Models\UserSessions::where('user_id' ,$user_id)->first();
		if($obj){
			$token = $obj->token;
			if(!$token){
				$obj->token = $hash;
				$obj->update();
				$token = $hash;
			}
		}
		else{

		  $obj = Models\UserSessions::create([
				'user_id' => $user_id,
				'token' => $hash
			]);	
		  $token = $obj->token;
		}
		
		return $token; 
	}


	public static function removeSpecialChars($string) {
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}

	public static function check_if_hash_exists($hash){
		return (boolean)Models\UserSessions::where('token',$hash)->count();
	}

	
	public static function generate_hash(){
		return Hash::make(time().rand(1,10000).rand(1,10000));
	}


	public static function processToken($token){
		return self::getUserId($token);
	}

	public static function getUserId($token){
		
		$user_token =  Models\UserSessions::where('token',trim($token))->first();

		if(empty($user_token))
			return Resp::errorCode(135);

	 	return $user_token->user_id;
	}

	public function get($token){
		$userid = $this->getUserId($token);
		return Models\Users::where('id',$userid[0])->first();
	}
}