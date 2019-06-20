<?php 
namespace App\Http\REST\home;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Libs\ZrApi;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class delete
{

	protected $rules = [
		'home_id' => 168,
	];	
  
	public function customer(Request $request, $user_id){

		$data = $request->get('data');

		$data['user_id'] = $user_id;
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$home = Models\Home::where('user_id',$user_id)
							->where('id', $data['home_id'])
							->count();
        
        if(!$home)
        	return ZrApi::errorCode(192);					

      	Models\Floor::where('home_id',$data['home_id'])->forceDelete();
      	Models\Room::where('home_id',$data['home_id'])->forceDelete();
      	Models\Machine::where('home_id',$data['home_id'])->forceDelete();
      	Models\SdetectValves::where('home_id',$data['home_id'])->forceDelete();
      	Models\Home::where('id',$data['home_id'])->forceDelete();

	     return ZrApi::success(['Home deleted successfully'], $request->get('token'));

	}
}
