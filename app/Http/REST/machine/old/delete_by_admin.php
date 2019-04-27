<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
 
class delete_by_admin
{
	
	protected $rules = [
        'machine_id' => 161,
        'token' => 149,
	];	
  
	
	
public function admin(Request $request, $user_id){
	
		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		
		$exists = Models\Machine::where('id',  $data['machine_id'])->count();
	
		if(!$exists)
			return Resp::errorCode(153);

		Models\Machine::where('id',  $data['machine_id'])->delete();

		return Resp::success(['Machine Deleted Successfully']);

	}
}
