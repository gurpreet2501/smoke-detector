<?php 
namespace App\Http\REST\valve;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\ZrApi;
use App\Libs\Validate;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class reset
{

	protected $rules = [
		'floor_id' => 187,
	];	
  
	public function customer(Request $request, $user_id){
		//Floor Add api
		$data = $request->get('data');
	
		$data['user_id'] = $user_id;
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$valve = Models\SdetectValves::where('floor_id', trim($data['floor_id']))
							->first();
  
    if(!$valve)
    	return ZrApi::errorCode(196);				
 
		 $valve->update(['valve_status' => 0]);

	   return ZrApi::success(['Valve reset successfull'], $request->get('token'));

	}
}
