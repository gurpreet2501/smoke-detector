<?php 
namespace App\Http\REST\room;
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
		'name' => 172,
		'home_id' => 168,
		'floor_id' => 171,
	];	
  
	public function customer(Request $request, $user_id){

		$data = $request->get('data');
	
		$data['user_id'] = $user_id;
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$room = Models\Room::where('user_id',$user_id)
							->where('name', trim($data['name']))
							->where('home_id', trim($data['home_id']))
							->count();
        
        if($room)
        	return ZrApi::errorCode(173);					

	  	$resp = Models\Room::create($data);

	    return ZrApi::success($resp->toArray(), $request->get('token'));

	}
}
