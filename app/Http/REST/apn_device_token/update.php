<?php 
namespace App\Http\REST\apn_device_token;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\ZrApi as Resp;
 
class update
{
	
	protected $rules = [
        'device_token' => 160
	];	
  
	public function customer(Request $request, $user_id){
		
		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
				
		$resp = Models\Users::where('id', $user_id)->update([
				'device_token' => $data['device_token']
		]);

		return Resp::success(['Device Token updated successfully']);

	}
}
