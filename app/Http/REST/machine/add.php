<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class add
{

	protected $rules = [
				'name' => 138,
        'serial_no' => 139,
        'carbon_monoxide' => 162,
        'lpg' => 162,
        'smoke' => 164,
        'air_purity' => 165,
        'temperature' => 166,
        'humidity' => 167,
        'home_id' => 168,
	];	
  
	public function customer(Request $request, $user_id){
				
		$data = $request->get('data');
		
		$data['user_id'] = $user_id;
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		

		$count = Models\Machine::where('serial_no', $data['serial_no'])->count();

		if($count)
			return Resp::errorCode(142);

		$resp = Models\Machine::create($data);

	  $machine_id = $resp->id;
	 

	 return Resp::success($resp->toArray(),$request->get('token'));

	}
}
