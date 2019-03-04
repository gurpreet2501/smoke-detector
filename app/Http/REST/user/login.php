<?php 
namespace App\Http\REST\user;
use App\Models;
use App\Libs\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
use App\Libs\Validate;


class login
{
	protected $rules = [
		    'email' => 126,
        'password' => 125,
        'device_id' => 158,
        'device_type' => 159,
        'device_token' => 160
	];	
	public function guest(Request $request,$user_id){

		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
	
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
	
			$resp = Validate::login($data);
		
			if($resp['STATUS'] == 'FAILED')
				 return Resp::errorCode(130);

		$resp = Models\Users::where('email',$data['email'])->first();
		$data = Validate::unsetFields($resp->toArray());
		$user_id = $resp->id;
		$token = User::generateToken($user_id);
		return Resp::success($data,$token);

	}
}
