<?php 
namespace App\Http\REST\password;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\User;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class update
{	
	protected $rules = [
        'password' => 125,
        'token' => 125,
	];	

	public function guest(Request $request, $user_id=null){

		$data = $request->get('data');

		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		

		$pass_length = strlen($data['password']);

		if($pass_length < 8 || $pass_length>15)
			return Resp::errorCode(152);

		$user = Models\Users::where('password_reset_token',$data['token'])->first();
		
		if(!$user)
			return Resp::errorCode(135);

		$user->password = Hash::make($data['password']);
		$user->password_reset_token = '';
		$user->save();

		return Resp::success(['Password Updated Successfully']);
	}

	

	
}
