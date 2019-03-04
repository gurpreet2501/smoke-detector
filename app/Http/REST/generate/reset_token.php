<?php 
namespace App\Http\REST\generate;
use App\Models;
use App\Libs\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
use App\Libs\Validate;
use App\Libs\Email;


class reset_token
{	
	protected $rules = [
        'email' => 126,
	];	

	public function guest(Request $request,$user_id){
		$data = $request->get('data');

		$req_fields = Validate::fields($data, $this->rules);
		if($req_fields['STATUS'] == 'FAILED')
			return $req_fields;
		 
		$user = Models\Users::where('email',$data['email'])->first();
		if(!$user)
			return Resp::errorCode(155);

		$token = User::generate_hash();
	    $reset_token = User::removeSpecialChars($token);		
	    $user->password_reset_token = $reset_token;
	    $user->update();
	    $message = 'Click the link below to reset your password: ';
	    $message .= env('RESET_PASSWORD_URL','http://theheavenhomes.com/sewer-web/index.php/reset/user_password').'?token='.$reset_token;

	    if(!Email::send('Password reset token',$message,'',$data['email']))
	    	return Resp::errorCode(156);

		return Resp::success(['Password reset token sent Successfully']);
	}
}
