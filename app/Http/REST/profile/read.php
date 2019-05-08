<?php 
namespace App\Http\REST\profile;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
 
class read
{
	  
	protected $rules = [
        
	];	
  
	public function customer(Request $request, $user_id){
		
		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$resp = Models\Users::where('id',$user_id)->first();
		
		if(!$resp)
			return Resp::errorCode(135);		
		$data = Validate::unsetFields($resp->toArray());
		return Resp::success($data);

	}
}
