<?php 
namespace App\Http\REST\user;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\User;
use App\Libs\ZrApi;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class create
{	
	protected $rules = [
	    'email' => 126,
        'password' => 125,
        'name' => 115,
        'username' => 127,
        'phone' => 144,
        'device_id' => 158,
        'device_token' => 160,
        'device_type' => 159,
	];	

	public function guest(Request $request, $user_id=null){

		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
			
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;

		$data['device_type'] = strtoupper($data['device_type']);
		
		$pass_length = strlen($data['password']);

		if($pass_length < 8 || $pass_length>15)
			return ZrApi::errorCode(152);

		$email_count = Models\Users::where('email', $data['email'])->count(); 
		if($email_count)
			return ZrApi::errorCode(128);

		$username_count = Models\Users::where('username', $data['username'])->count();
		if($username_count)
			return ZrApi::errorCode(127);

		$data['password'] = Hash::make($data['password']);
		$data['activated'] = 1;
		$data['role'] = 'CUSTOMER';
		
		$resp = Models\Users::create($data);
			
		$token = User::generateToken($resp->id);

	 	$output = $resp->toArray();
	 	
	 	unset($output['password']);

		return ZrApi::success($output,$token);
	}

	

	
}
