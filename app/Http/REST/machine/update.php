<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Libs\ZrApi;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class update
{

	protected $rules = [
     
      'machine_id' => 161
	];	
  
	public function customer(Request $request, $user_id){
				
		$data = $request->get('data');

		$data['user_id'] = $user_id;
		$machine_id = $data['machine_id'];
	
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED') 
			return $req_fields;
		
	
	 	$machine = [];
		
		$machine = Models\Machine::where('id', $data['machine_id'])
							->where('user_id',$data['user_id'])->first();
							
		//Checking if key is not present then it will add the condition with null		
		
		unset($data['user_id']);
		unset($data['machine_id']);
		unset($data['floor_id']);
		unset($data['room_id']);
		unset($data['home_id']);

		if(!$machine)
			return ZrApi::errorCode(186);

		$machine->update($data);

		$machine = Models\Machine::find($machine_id);

	  return ZrApi::success($machine->toArray(),$request->get('token'));

	}
	
}
