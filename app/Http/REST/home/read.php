<?php 
namespace App\Http\REST\home;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class read
{

	protected $rules = [
	];	
  
	public function customer(Request $request, $user_id){

		$data = $request->get('data');
	
		$data['user_id'] = $user_id;
	
		$resp = [];

		$resp = Models\Home::where('user_id',$user_id)
							->get();
    
    if(count($resp))
    	$resp = $resp->toArray();
     
	  return Resp::success($resp, $request->get('token'));

	}
}
