<?php 
namespace App\Http\REST\profile;
use App\Models;
use App\Libs\User;
use App\Libs\ZrApi;
use Illuminate\Http\Request;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
 
class read
{
	  
	protected $rules = [
        
	];	
  
	public function customer(Request $request, $user_id){
		
		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$resp = Models\Users::with('machines')->where('id',$user_id)->first();
		
		$machines_count = !empty($resp->machines) ? count($resp->machines) : 0; 
		
		if(!$resp)
			return Resp::errorCode(135);

		$data = Validate::unsetFields($resp->toArray());

		$total_shared_machines = Models\SharedMachines::where('shared_by',$user_id)->count();

		$data['machines_count'] = $machines_count;
		$data['total_shared_machines'] = $total_shared_machines;

		$token = User::generateToken($user_id);
		return ZrApi::success($data,$token);

	}
}
