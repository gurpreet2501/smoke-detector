<?php 
namespace App\Http\REST\button_status;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
 
class update
{
	
	protected $rules = [
        'machine_serial' => 139,
        'button_status' => 157,
	];	
  
	public function guest(Request $request, $user_id){
		
		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
				
		$resp = Models\Machine::where('machine_serial',trim($data['machine_serial']))->first();

		if(!$resp)
			return Resp::errorCode(150);		

		$resp->button_status = $data['button_status'];

		$resp->save();
		
		return Resp::success($resp->toArray());

	}
}
