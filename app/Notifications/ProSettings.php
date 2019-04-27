<?php
/**
* 
*/
namespace app\Notifications;
use DB;

class ProSettings
{
	
	function __construct($user_id)
	{
		$this->user_id = $user_id;
	}
    
	function check($notification_type, $value){
		$currentflag = DB::table('pro_settings')->where('user_id',$this->user_id)->pluck($notification_type);
		if($currentflag == $value)
			return true;
		else if($currentflag == 'both')
			return true;
		else 
			return false;
	}

	function locationServices(){
		return (Boolean)DB::table('pro_settings')->where('user_id',$this->user_id)->pluck('location_services');	
	}

	function textMessaging(){
		return (Boolean)DB::table('pro_settings')->where('user_id',$this->user_id)->pluck('text_messaging');	
	}
}