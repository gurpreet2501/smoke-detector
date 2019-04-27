<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
 
class block
{
	
	protected $rules = [
        'machine_serial' => 139,
        'token' => 149,
	];	
  
	public function admin(Request $request, $user_id){
		
		$data = $request->get('data');
		
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		

		$resp = Models\Machine::where('machine_serial',trim($data['machine_serial']))->first();
		
		if(!$resp)
	 		return Resp::errorCode(150);

	 	$added_by = $resp->added_by;

	 	Models\Machine::where('machine_serial',trim($data['machine_serial']))->update([
	 		'blocked' => 1
	 	]);
 			
	 	try{

 		 Notifications::push()->toCustomer(
			            $resp->added_by,
			            'machine-blocked',
			            ['machine_name' => $resp->machine_name],
			            ['notification_type'  => 'status', 'machine_type'  => $resp->type]
			           
		  );
		}catch(Exception $e){
			
		}    

		return Resp::success(['Machine blocked Successfully']);

	}
}
