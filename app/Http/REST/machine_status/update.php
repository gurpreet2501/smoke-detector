<?php 
namespace App\Http\REST\machine_status;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
 
class update
{
	
	protected $rules = [
        'machine_serial' => 139,
        'machine_status' => 157,
	];	
  
	public function guest(Request $request, $user_id){
		
		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
				
		$resp = Models\Machine::where('machine_serial', trim($data['machine_serial']))->first();
	
		if(!$resp)
			return Resp::errorCode(150);		

		$resp->status = $data['machine_status']; 

		//If machine status is set to 0. Then send notifications to customer that something wrong had happened
		if($data['machine_status'] == 0){
		
				// $resp->button_status = 0;			 
		
	     if($resp->type == 'GAS'){
	     		//added_by means this machine is added by this user id..
				 	Notifications::push()->toCustomer(
			            $resp->added_by,
			            'leakage-detected',
			            ['machine_name' => $resp->machine_name],
			            ['notification_type'  => 'status', 'machine_type'  => $resp->type]
			           
			    );  

	     }else{
	     
	     		Notifications::push()->toCustomer(
			            $resp->added_by,
			            'main-hole-blocked',
			            ['machine_name' => $resp->machine_name],
			            ['notification_type'  => 'status', 'machine_type'  => $resp->type]
			           
			    );
	     }

		}
		
		//If machine status is set to 1. Then send notifications to customer that everything is normal
		if($data['machine_status'] == 1){

				// $resp->button_status = 1;			 

	     if($resp->type == 'GAS'){
	     	
				 	Notifications::push()->toCustomer(
			            $resp->added_by,
			            'leakage-problem-resolved',
			            ['machine_name' => $resp->machine_name],
			            ['notification_type'  => 'status', 'machine_type'  => $resp->type]
			           
			    );  

	     }else{
	     
	     		Notifications::push()->toCustomer(
			            $resp->added_by,
			            'main-hole-is-open-now',
			            ['machine_name' => $resp->machine_name],
			            ['notification_type'  => 'status', 'machine_type'  => $resp->type]
			           
			    );
	     }

		}


		$resp->save();
		
		return Resp::success($resp->toArray());

	}

	
}
