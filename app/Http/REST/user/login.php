<?php 
namespace App\Http\REST\user;
use App\Models;
use App\Libs\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
use App\Libs\Validate;
use App\Libs\ZrApi;
use App\Libs\NotificationsP8 as APN;


class login
{
	protected $rules = [
		    'email' => 126,
        'password' => 125,
        'device_id' => 158,
        'device_type' => 159,
        'device_token' => 160
	];	

	public function guest(Request $request, $user_id){
     phpinfo();
    
		$data = $request->get('data');
	
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields)
			return $req_fields;
	
			$resp = Validate::login($data);
		
			if($resp['STATUS'] == 0) 
				 return ZrApi::errorCode(130);

		$resp = Models\Users::where('email',$data['email'])->first();
		$data = Validate::unsetFields($resp->toArray());
		
		$user_id = $resp->id;

		APN::send('Login Successfull', $user_id);

		$token = User::generateToken($user_id);
		return ZrApi::success($data,$token);

	}
}
