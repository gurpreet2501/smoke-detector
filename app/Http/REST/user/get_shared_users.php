<?php 
namespace App\Http\REST\user;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\User;
use App\Libs\ZrApi;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class get_shared_users
{	
	protected $rules = [
	 
	];	

	public function customer(Request $request, $user_id=null){


		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
			
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
	

		$Shared_machines_with_users = Models\SharedMachines::where('shared_by', $user_id)
														->with('sharedUser')
														->with('machine')
														->get(); 
	

		if(count($Shared_machines_with_users) <= 0)
			return ZrApi::errorCode(191);

		return ZrApi::success($Shared_machines_with_users,$request->get('token'));
	}

	

	
}
