<?php 
namespace App\Http\REST\floor;
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
	];	
  
	public function customer(Request $request, $user_id){
		//Floor Add api
		$data = $request->get('data');
	
		$data['user_id'] = $user_id;
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$floor = Models\Floor::where('user_id',$user_id)
							->where('name', trim($data['name']))
							->count();
        
    if($floor)
    	return ZrApi::errorCode(172);					

		$resp = Models\Floor::create($data);

	    return ZrApi::success($resp->toArray(), $request->get('token'));

	}
}
