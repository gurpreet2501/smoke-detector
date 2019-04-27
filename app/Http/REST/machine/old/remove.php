<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
 
class remove
{
	
	protected $rules = [
        'machine_serial' => 139,
        'token' => 149,
	];	
  
	public function customer(Request $request, $user_id){

		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$exists = Models\Machine::where('added_by',  $user_id)->where('machine_serial',trim($data['machine_serial']))->first();
	
		if(!$exists)
			return Resp::errorCode(153);

		Models\Machine::where('added_by',  $user_id)->where('machine_serial',$data['machine_serial'])->delete();

		return Resp::success(['Machine Removed Successfully']);

	}
	
}
