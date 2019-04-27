<?php 
namespace App\Http\REST\floor;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Libs\ZrApi;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class read
{

	protected $rules = [
		'home_id' => 168
	];	
  
	public function customer(Request $request, $user_id){

		$data = $request->get('data');
	
		$data['user_id'] = $user_id;
	
		$resp = [];

		$resp = Models\Floor::where('user_id',$user_id)
							->where('home_id',$data['home_id']) 
							->get();
    
    if(count($resp))
    	$resp = $resp->toArray();
     
	  return ZrApi::success($resp, $request->get('token'));

	}
}
