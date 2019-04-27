<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class view
{
	
	protected $rules = [
        'type' => 140,
        'token' => 149
	];	
  
	public function customer(Request $request, $user_id){

		$data = $request->get('data');

		$req_fields = Validate::fields($data, $this->rules);
	
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$data['type'] = strtoupper($data['type']);
		
		if(($data['type'] != 'GAS') && ($data['type'] != 'SEWERAGE')){
			return Resp::errorCode(154);
		}

		$machines = Models\Machine::where('added_by',$user_id)
									->with('address')
									->where('TYPE',$data['type'])
									->get();
		
   	   return Resp::success($machines->toArray());

	}


	public function admin(Request $request, $user_id){

		$data = $request->get('data');

		$req_fields = Validate::fields($data, $this->rules);
	
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$data['type'] = strtoupper($data['type']);
	
		if(($data['type'] != 'GAS') && ($data['type'] != 'SEWERAGE') && ($data['type'] != 'ALL')){
			return Resp::errorCode(154);
		}

		if(isset($data['paginate']) && isset($data['page_no'])){
			 $machines = new Models\Machine;
		
			 if(isset($data['status']) && ($data['status'] != 2))
				 	$machines = $machines->where('status',$data['status']);

		
			 if(isset($data['button_status']) && ($data['button_status'] != 2))
				 	$machines = $machines->where('button_status',$data['button_status']);

			if(isset($data['blocked']) && ($data['blocked'] != 2))
				 	$machines = $machines->where('blocked',$data['blocked']);

			if(isset($data['machine_serial']) && (strlen(trim($data['machine_serial'])) > 0))
				 	$machines = $machines->where('machine_serial', $data['machine_serial']);

			 if($data['type']!= 'ALL')
				 	$machines = $machines->where('type',$data['type']);

			 $machines = $machines->paginate(15, ['*'], 'page', $data['page_no']);
			
		}else{

			 $machines = new Models\Machine;
		
			 if($data['type']!= 'ALL')
		   		$machines = Models\Machine::where('TYPE',$data['type']);

			 $machines = $machines->get();
		}
									

	   return Resp::success($machines->toArray());

	}
}
