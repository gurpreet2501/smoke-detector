<?php 
namespace App\Http\REST\user;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\User;
use App\Libs\ZrApi;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class search
{	
	protected $rules = [
	      'keyword' => 184,
	];	

	public function guest(Request $request, $user_id=null){

		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
			
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
	

		$users = Models\Users::where('email','like' ,'%'.$data['keyword'].'%')
													  ->where('role','CUSTOMER')
														->get(); 
		
		if(count($users) <= 0)
			return ZrApi::errorCode(185);

		return ZrApi::success($users,$request->get('token'));
	}

	

	
}
