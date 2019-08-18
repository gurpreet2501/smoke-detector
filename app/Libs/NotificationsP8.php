<?php 
namespace App\Libs; 
use App\Models;
use App\Libs\Notifications\Factory as Resp;
use Illuminate\Support\Facades\Hash;


use Pushok\AuthProvider;
use Pushok\Client;
use Pushok\Notification;
use Pushok\Payload;
use Pushok\Payload\Alert;
/**
* 
*/
class NotificationsP8
{
	
	function __construct()
	{
		
	}

	public static function send($notification_title, $user_id){
			$apn_env = false;
 			
 			$user = Models\Users::where('id',$user_id)->first();
 			
 			if(!$user)
 				return false;

 			if(env('APN_ENVIRONMENT') == 'PRODUCTION')
 				$apn_env = true;

 			$options = [
			    'key_id' => env('APN_KEY_ID'), // The Key ID obtained from Apple developer account
			    'team_id' => env('APN_TEAM_ID'), // The Team ID obtained from Apple developer account
			    'app_bundle_id' => env('APN_APP_BUNDLE_ID'), // The bundle ID for app obtained from Apple developer account
			    'private_key_path' => storage_path('app_certs/AuthKey_CA7HY748WQ.p8'), // Path to private key
			    'private_key_secret' => null // Private key secret
			];
			
			$authProvider = AuthProvider\Token::create($options);
		
			$alert = Alert::create()->setTitle($notification_title);

			$payload = Payload::create()->setAlert($alert);
		
			$deviceTokens = [$user->device_token];

			$notifications = [];
			foreach ($deviceTokens as $deviceToken) {
			    $notifications[] = new Notification($payload, $deviceToken);
			}
			
			$client = new Client($authProvider, $production = $apn_env);
			$client->addNotifications($notifications);

			$responses = $client->push(); // returns an array of Responses (one Response per Notification)
			
			foreach ($responses as $response) {
				
			    // $response->getApnsId();
			    if($response->getStatusCode() == 400)
			    	return false;

			    return true;
			    
			    // $response->getReasonPhrase();
			    // $response->getErrorReason();
			    // $response->getErrorDescription();
			}

	}

}