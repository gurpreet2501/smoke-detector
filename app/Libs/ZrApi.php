<?php /**
* 
*/
namespace App\Libs;
class ZrApi
{
	
	function __construct($resp)
	{
		$this->resp = $resp;
	}
	
	public static function json($data){

		return response()->json($data);
	}

	public static function successWithoutToken($data){
		
		return [
		'STATUS' => 1,
		'RESPONSE'   => $data,
		'ERRORS' => []
		];
	}



	public static function success($data,$token=null){
		
		return [
		'STATUS' => 1,
		'TOKEN'  => $token,
		'RESPONSE' => $data,
		];
	}

	public static function errorCode($code){
		
		return ["MESSAGE" => config("errors.{$code}"), "STATUS" => 0];

	}

}
