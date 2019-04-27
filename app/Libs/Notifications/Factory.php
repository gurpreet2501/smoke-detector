<?php /**
* 
*/
namespace App\Libs\Notifications;
class Factory
{

	public static function success($data,$token=null){
		
		return [
		'STATUS' => 'SUCCESS',
		'TOKEN'  => $token,
		'RESPONSE'   => $data,
		'ERRORS' => []
		];
	}

	public static function errorCode($code){
		
		return [
		'STATUS' => 'FAILED',
		'ERRORS' => [$code => config("errors.{$code}")]
		];
	}
	
	public static function error($error){
		
		return [
		'STATUS' => 'FAILED',
		'ERRORS' => ['123' => $error]
		];
	}

	public static function errors($errors){
		
		$errors = (array)$errors;
		$errors  = array_values(array_shift($errors));
		$errFilter = [];
		foreach ($errors as $key => $val) {
			$errFilter[$val[0]] = config("errors.{$val[0]}");
		}
		
		return [
		'STATUS' => 'FAILED',
		'ERRORS' => $errFilter
		];
	}

} ?>