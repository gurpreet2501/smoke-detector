<?php 
namespace App\Http\REST\room;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Libs\ZrApi;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class read
{

	protected $rules = [];	
  
	public function customer(Request $request, $user_id){

		$data = $request->get('data');
	
		$data['user_id'] = $user_id;
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		

		$req_keys = ['home_id','floor_id'];

		$rooms =  Models\Room::where('user_id',$user_id)
													->with('home')
													->with('floor');

		//Checking if key is not present then it will add the condition with null		
		foreach ($req_keys as $key) {
			
					if(!empty($data[$key]) && $data[$key]>0)
						$rooms = $rooms->where($key,$data[$key]);
					// else
					// 	$rooms = $rooms->where($key,NULL);
		}						

		$rooms = $rooms->get();
		
		if(!count($rooms))
		  return ZrApi::errorCode(175);		

	
	  	

	    return ZrApi::success($rooms->toArray(), $request->get('token'));

	}
}
