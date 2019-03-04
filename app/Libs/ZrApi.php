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

	public static function success($resp){
		
		$data = [
			'STATUS' => 'SUCCESS',
			'RESPONSE' => is_object($resp) ? $resp->toArray() : $resp
		];
    
		return response()->json($data);
	}
	
	public static function json($data){
		return response()->json($data);
	}

}
