<?php
namespace App\Libs;
use App\Libs\JwtApns;
/*
c
imple iOS push notification with auth key
*/

/**
* 
*/
class SendNotificationsApns 
{
	
	function __construct()
	{
		# code...
	}

public static	function push_to_apns($arParam, &$ar_msg){

	$arSendData = array();

	$url_cnt = "https://www.google.com";
	$arSendData['aps']['alert']['title'] = sprintf("Notification Title"); // Notification title
	$arSendData['aps']['alert']['body'] = sprintf("Body text"); // body text
	$arSendData['data']['jump-url'] = $url_cnt; // other parameters to send to the app

	$sendDataJson = json_encode($arSendData);
  
	$endPoint = 'https://api.development.push.apple.com/3/device'; // https://api.push.apple.com/3/device

	//　Preparing request header for APNS
	$ar_request_head[] = sprintf("content-type: application/json");
	$ar_request_head[] = sprintf("authorization: bearer %s", $arParam['header_jwt']);
	$ar_request_head[] = sprintf("apns-topic: %s", $arParam['apns-topic']);

	$dev_token = 'ce64107bab008b7d12b0f6096dcd580cbbee7f4a7cd0b827408ed67b0aa65a3b';  // Device token

	$url = sprintf("%s/%s", $endPoint, $dev_token);
	echo "<pre>";
	print_r($url);
	exit;
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $sendDataJson);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $ar_request_head);
	$response = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if(empty(curl_error($ch))){
    // echo "empty curl error \n";
	}

	// Logging
  // After we need to remove device tokens which had response code 410.
  /*
		if(intval($httpcode) == 200){ fwrite($fp_ok, $output); }
		else{ fwrite($fp_ng, $output); }

		if(intval($httpcode) == 410){ fwrite($fp_410, $output); }
  */
	curl_close($ch);

	return TRUE;
}
}

// ***********************************************************************************


?>

