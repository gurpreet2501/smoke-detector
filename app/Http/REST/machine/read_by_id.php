<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Libs\ZrApi;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class read_by_id
{

	protected $rules = [
     
      'machine_id' => 161
	];	
  
	public function customer(Request $request, $user_id){
				
		$data = $request->get('data');
		
		$data['user_id'] = $user_id;
	
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED') 
			return $req_fields;
	
	 	$machines = [];
		
		$req_keys = ['home_id','floor_id','room_id'];

		$machines = Models\Machine::where('id', $data['machine_id'])
							->where('user_id',$data['user_id'])->first();
							
		//Checking if key is not present then it will add the condition with null		
		
		if(count($machines))
			$machines = $machines->toArray();

	  return ZrApi::success($machines,$request->get('token'));

	}
	
}
