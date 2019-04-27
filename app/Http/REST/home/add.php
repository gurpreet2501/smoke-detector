<?php 
namespace App\Http\REST\home;
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
		'address' => 143,
		'pin_code' => 169,
		'latitude' => 148,
		'longitude' => 149,
	];	
  
	public function customer(Request $request, $user_id){

		$data = $request->get('data');

		$data['user_id'] = $user_id;
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$home = Models\Home::where('user_id',$user_id)
							->where('name', trim($data['name']))
							->count();
        
        if($home)
        	return ZrApi::errorCode(170);					

		$resp = Models\Home::create($data);

	    return ZrApi::success($resp->toArray(), $request->get('token'));

	}
}
