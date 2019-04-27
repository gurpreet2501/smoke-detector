<?php /**
* 
*/
namespace App\Libs;
use App\Models;
use App\Libs\ZrApi;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
class Validate
{    

	function __construct()
	{
		$this->resp = [];
	}

	public static function login($data){
	
		$email = !empty($data['email']) ? $data['email'] : null;
		$password = !empty($data['password']) ? $data['password'] : null;

		if(!$password)
			return ZrApi::errorCode(125);

		if(!$email)
			return ZrApi::errorCode(129);

		$resp = Models\Users::where('email', $email)->first();
		
		if(!$resp)
			return ZrApi::errorCode(130);
		
		if($resp->email != $email)
			return ZrApi::errorCode(130);

		if(!Hash::check($password, $resp->password))
			return ZrApi::errorCode(130);
		
		
		 //Bind Device Id and device token
		 $resp->device_id = $data['device_id'];
		 $resp->device_token = $data['device_token'];
		 $resp->device_type = strtoupper($data['device_type']);
		 $resp->save();

		 return ZrApi::success([]);

	}
	
	public static function unsetFields($data){
		$fields = ['banned','ban_reason','new_password_key','new_email','new_email_key','last_ip','last_login','password','password_reset_token','new_password_requested'];
		foreach ($fields as $key => $value) {
			unset($data[$value]);
		}

		return $data;
	}

	public static function bindToken($data){

		$token = User::generateToken($data['id']);

		if(empty($token))
			return ZrApi::errorCode(131);
		
		$data['token'] = $token;
		
		return $data;
	}

	public static function fields($data,$rules){
		
			foreach ($rules as $key => $v) {
				
				if(!isset($data[$key]))
					return ZrApi::errorCode($v);

			}
	}



	public static function postParams($post){
		
		$filtered_post = [];
		foreach ($post['data'] as $key => $v) {
			$filtered_post[$key] = htmlspecialchars($v);
		}
		return $filtered_post;
	}

}
