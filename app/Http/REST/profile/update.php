<?php 
namespace App\Http\REST\profile;
use App\Models;
use App\Libs\User;
use App\Libs\ZrApi;
use Illuminate\Http\Request;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
 
class update
{
	  
	protected $rules = [
        
	];	
  
	public function customer(Request $request, $user_id){
		
		$data = $request->all();
		
		$update_fields = [];

		$fields_to_update = ['name','profile_pic'];
		foreach ($fields_to_update as $key => $field) {
			if(isset($data[$field]))
				$update_fields[$field] = $data[$field];

		}
		
		if(!count($update_fields))
			return ZrApi::errorCode(176);

		$resp = Models\Users::where('id',$user_id)->update($update_fields);

		if(!$resp)
				return ZrApi::errorCode(177);

		$resp = Models\Users::find($user_id);	

	
		$resp = Validate::unsetFields($resp->toArray());

		// $data['machines_count'] = $machines_count;
		// $token = User::generateToken($user_id);
		return ZrApi::success($resp,$data['token']);

	}
}
