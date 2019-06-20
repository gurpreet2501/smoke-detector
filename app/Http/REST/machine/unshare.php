<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Libs\ZrApi;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class unshare
{

	protected $rules = [
     
      'shared_with_user_id' => 193,

	];	
  
	public function customer(Request $request, $user_id){
				
		$data = $request->get('data');

		$data['user_id'] = $user_id;
	
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED') 
			return $req_fields;
		
		$shared = Models\SharedMachines::where('shared_with', $data['shared_with_user_id'])
																	->where('shared_by', $user_id)
																	->delete();


	  return ZrApi::success(['Machine sharings removed']);

	}
	
}
