<?php 
namespace App\Http\REST\machine;
use App\Models;
use Illuminate\Http\Request;
use App\Libs\Validate;
use App\Libs\ZrApi;
use App\Notifications\Factory as Notifications;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;

class read
{

	protected $rules = [
     
      'home_id' => 168
	];	
  
	public function customer(Request $request, $user_id){
				
		$data = $request->get('data');
		

			// Send notification to admin to share machine

					 Notifications::push()->toCustomer(
				            $user_id,
				            'machine-unblocked',
				            ['machine_name' => 'Machine 1'],
				            ['notification_type'  => 'status', 'machine_type'  => 'Test']
				           
			  		); 




		$data['user_id'] = $user_id;
	
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields['STATUS'] == 'FAILED') 
			return $req_fields;
	
	 	$machines = [];
		
		$req_keys = ['home_id','floor_id','room_id'];

		$machines = Models\Machine::where('home_id', $data['home_id'])
							->where('user_id',$data['user_id']);
							
		//Checking if key is not present then it will add the condition with null		
		foreach ($req_keys as $key) {
			
					if(!empty($data[$key]) && $data[$key]>0)
						$machines = $machines->where($key,$data[$key]);
					else
						$machines = $machines->where($key,NULL);
		}						

		$machines = $machines->get();

		if(count($machines))
			$machines = $machines->toArray();


		// get Shared machines
		$shared_machines = [];
		$shared_machines = Models\SharedMachines::has('machine')->with('machine')->where('shared_with',$user_id)->get();

		if(count($shared_machines))
			$shared_machines = $shared_machines->toArray();


		$machines = [
			'user_machines' => $machines,
			'shared_machines' => $shared_machines
			
		];

	  return ZrApi::success($machines,$request->get('token'));

	}
	
}
