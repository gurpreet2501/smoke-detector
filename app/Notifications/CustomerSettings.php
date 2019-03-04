<?php
/**
* 
*/
namespace app\Notifications;
use DB;

class CustomerSettings
{
	function __construct($user_id)
	{
		$this->user_id = $user_id;
	}
    
	function check($notification_type){
		return DB::table('customer_settings')->where('user_id', $this->user_id)->pluck($notification_type);

	}
	
}