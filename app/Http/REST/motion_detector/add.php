<?php 
namespace App\Http\REST\motion_detector;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\User;
use App\Libs\ZrApi;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class add
{	
	protected $rules = [
	      'serial' => 178,
        'name' => 115,
        'machine_id' => 161,
        'status' => 179
	];	

	public function customer(Request $request, $user_id=null){

		$data = $request->get('data');
	
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;

		//Chekcig if machine is associated with current logged in user or not
		$exists = Models\Machine::where('user_id',$user_id)
											->where('id', $data['machine_id'])
											->count();
		
		if(!$exists)
			return ZrApi::errorCode(153);



		$exists = Models\MotionDetectors::where('user_id',$user_id)
											->where('machine_id', $data['machine_id'])
											->where('serial', $data['serial'])
											->count();
		
		if($exists)
			return ZrApi::errorCode(180);

		$resp  = Models\MotionDetectors::create([
			'name' => $data['name'],
			'status' => $data['status'],
			'serial' => $data['serial'],
			'machine_id' => $data['machine_id'],
			'user_id' => $user_id,
		]);

	 	$output = $resp->toArray();

		return ZrApi::success($output);
	}

	

	
}
