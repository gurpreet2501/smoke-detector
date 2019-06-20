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
		
		if(!$resp)
			return Resp::errorCode(135);


		$machines_count = !empty($resp->machines) ? count($resp->machines) : 0; 

		$machine_ids = [];

		foreach ($resp->machines as $key => $mac) {
			$machine_ids[] = $mac->id;
		
		}
		

		$machines_shared_with = Models\SharedMachines::whereIn('machine_id',$machine_ids)->count();
		
		$data = Validate::unsetFields($resp->toArray());

		$total_shared_machines = Models\SharedMachines::where('shared_by',$user_id)->count();

		$data['machines_count'] = $machines_count;
		$data['total_shared_machines'] = $total_shared_machines;
		$data['total_users_having_shared_machines_access'] = $machines_shared_with;

		$token = User::generateToken($user_id);
		return ZrApi::success($data,$token);

	}
}
