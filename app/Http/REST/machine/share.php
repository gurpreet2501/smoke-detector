<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Libs\ZrApi;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class share
{

	protected $rules = [
     
      'machine_id' => 161,
      'shared_with' => 183,

	];	
  
	public function customer(Request $request, $user_id){
				
		$data = $request->get('data');

		$data['user_id'] = $user_id;
	
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED') 
			return $req_fields;
		
		$shared = Models\SharedMachines::where('shared_with', $data['shared_with'])->where('machine_id',$data['machine_id'])->count();

		if($shared)
			return ZrApi::errorCode(174);

		foreach ($data['shared_with'] as $key => $single_rec) {
				 Models\SharedMachines::firstOrCreate([
				'shared_with' => $single_rec,
				'shared_by' => $user_id,
				'machine_id' => $data['machine_id']
			]);
		}
	

	  return ZrApi::success(['Machines shared successfully']);

	}
	
}
