<?php 
namespace App\Http\REST\user;
use App\Models;
use App\Libs\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
use App\Libs\Validate;

class logout
{
	public function customer(Request $request,$user_id){
		
		Models\UserSessions::where('user_id',$user_id)->update(['token' => '']);

		Models\Users::where('id',$user_id)->update([
			'device_id' => ''
		]);
	
		return Resp::success(['User Logged Out Successfully']);

	}
}
