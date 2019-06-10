<?php 
namespace App\Http\REST\valve;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\ZrApi;
use App\Libs\Validate;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class add
{

	protected $rules = [
		'name' => 172,
		'home_id' => 168,
		'floor_id' => 187,
		'serial_id' => 188,
		'valve_status' => 190,
	];	
  
	public function customer(Request $request, $user_id){
		//Floor Add api
		$data = $request->get('data');
	
		$data['user_id'] = $user_id;
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$valve = Models\SdetectValves::where('serial_id', trim($data['serial_id']))
							->first();
        
    if($valve)
    	return ZrApi::errorCode(189);				
 
		 $resp = Models\SdetectValves::create($data);

	    return ZrApi::success($resp->toArray(), $request->get('token'));

	}
}
