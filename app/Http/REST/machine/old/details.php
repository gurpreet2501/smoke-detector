<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate; 
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class details
{
	
	protected $rules = [
        'token' => 149,
        'machine_id' => 161
	];	
  
	public function admin(Request $request, $user_id){

		$data = $request->get('data');
	
		$req_fields = Validate::fields($data, $this->rules);
	
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$machine = Models\Machine::with('address')->where('id',$data['machine_id'])->first();
		
		if(!$machine)
				return Resp::errorCode(150);

	  return Resp::success($machine->toArray());

	}

}
