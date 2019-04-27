<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Libs\ZrApi;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class add
{

	protected $rules = [
				'name' => 138,
        'serial_no' => 139,
     
        'home_id' => 168,
	];	
  
	public function customer(Request $request, $user_id){
				
		$data = $request->get('data');
		
		$data['user_id'] = $user_id;
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		

		$res = Models\Machine::where('serial_no', $data['serial_no'])->first();

		//If machine already added by user_id else sharing of that machine will be made in the else part
		if($res){

				if($res->user_id == $user_id)
					return ZrApi::errorCode(142);
				else {
				
					$shared = Models\SharedMachine::where('user_id', $user_id)
						->where('machine_id', $res->id)
						->where('user_id', $user_id)
						->where('shared_by', $res->user_id)
						->count();

					if($shared)
						return ZrApi::errorCode(174);

					Models\SharedMachine::create([
						'user_id' => $user_id,
						'machine_id' => $res->id,
						'shared_by' => $res->user_id,
						'is_approved' => 0
					]);

					//Send notification to admin to share machine

					 // Notifications::push()->toCustomer(
				  //           $res->user_id,
				  //           'machine-unblocked',
				  //           ['machine_name' => $resp->machine_name],
				  //           ['notification_type'  => 'status', 'machine_type'  => $resp->type]
				           
			  	// 	); 


					return ZrApi::success($res->toArray(),$request->get('token'));

				}
		}
		

		$data['is_admin'] = 1;


		$resp = Models\Machine::create($data);

	  $machine_id = $resp->id;
	 

	 return Resp::success($resp->toArray(),$request->get('token'));

	}
}
