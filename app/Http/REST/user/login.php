<?php 
namespace App\Http\REST\user;
use App\Models;
use App\Libs\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Libs\Notifications\Factory as Resp;
use App\Libs\Validate;
use App\Libs\ZrApi;


use Pushok\AuthProvider;
use Pushok\Client;
use Pushok\Notification;
use Pushok\Payload;
use Pushok\Payload\Alert;

class login
{
	protected $rules = [
		    'email' => 126,
        'password' => 125,
        'device_id' => 158,
        'device_type' => 159,
        'device_token' => 160
	];	

	public function guest(Request $request,$user_id){
 			
 			$options = [
			    'key_id' => env('APN_KEY_ID'), // The Key ID obtained from Apple developer account
			    'team_id' => env('APN_TEAM_ID'), // The Team ID obtained from Apple developer account
			    'app_bundle_id' => env('APN_APP_BUNDLE_ID'), // The bundle ID for app obtained from Apple developer account
			    'private_key_path' => storage_path('app_certs/AuthKey_CA7HY748WQ.p8'), // Path to private key
			    'private_key_secret' => null // Private key secret
			];
			
			$authProvider = AuthProvider\Token::create($options);
		
			$alert = Alert::create()->setTitle('Hello!');
			$payload = Payload::create()->setAlert($alert);
			
			$deviceTokens = ['95a39a36d474ce54b198628322fa7acfa216474a7ec118918d72d20cc3fdcb67'];

			$notifications = [];
			foreach ($deviceTokens as $deviceToken) {
			    $notifications[] = new Notification($payload, $deviceToken);
			}
			
			$client = new Client($authProvider, $production = true);
			$client->addNotifications($notifications);

			$responses = $client->push(); // returns an array of Responses (one Response per Notification)
			echo "<pre>";
			print_r($responses);
			exit;
			foreach ($responses as $response) {
			    $response->getApnsId();
			    $response->getStatusCode();
			    echo "<pre>";
			    print_r($response->getStatusCode());
			    exit;
			    $response->getReasonPhrase();
			    $response->getErrorReason();
			    $response->getErrorDescription();
			}

     
		$data = $request->get('data');
	
		$req_fields = Validate::fields($data, $this->rules);
		
		if($req_fields)
			return $req_fields;
	
			$resp = Validate::login($data);
		
			if($resp['STATUS'] == 0) 
				 return ZrApi::errorCode(130);

		$resp = Models\Users::where('email',$data['email'])->first();
		$data = Validate::unsetFields($resp->toArray());
		
		$user_id = $resp->id;
		$token = User::generateToken($user_id);
		return ZrApi::success($data,$token);

	}
}
