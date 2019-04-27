<?php

namespace App\Notifications\Push;
use DB;
use \ApnsPHP_Push;
use \ApnsPHP_Abstract;
use \ApnsPHP_Message;
use \Exception;
use App\Models;

require_once __DIR__ .'/../../../third_party/ApnsPHP/Autoload.php';


class Apple{
  private $_senderConsumerApp = null,
          $_senderProApp      = null,
          $_lastError         = null,
          $_mode              = null;

  const PRODUCTION_MODE = 'PRODUCTION';
  const SANDBOX_MODE    = 'SANDBOX';

  function __construct( $mode = 'PRODUCTION', ApnsPHP_Push $senderConsumerApp = null, ApnsPHP_Push $senderProApp = null){
    $this->_mode = ($mode == self::PRODUCTION_MODE)? $mode: self::SANDBOX_MODE;

    if(!is_null($senderConsumerApp))
      $this->_senderConsumerApp = $senderConsumerApp;

    if(!is_null($senderProApp))
      $this->_senderProApp = $senderProApp;
  }

  function lastError(){
    return $this->_lastError;
  }

  function senderConsumerApp(){
    if(!is_null($this->_senderConsumerApp))
      return $this->_senderConsumerApp;

    if($this->_mode == self::PRODUCTION_MODE)
      $certFile = __DIR__.'/apple-certs/ConsumerPushProduction.pem';
    else
      $certFile = __DIR__.'/apple-certs/ConsumerPushDev.pem';

    $sender   =  $this->createSender($certFile);

    if(!$sender)
      return false;

    $this->_senderConsumerApp = $sender;
    return $this->_senderConsumerApp;
  }

  function senderProApp(){
    if(!is_null($this->_senderProApp))
      return $this->_senderProApp;

    if($this->_mode == self::PRODUCTION_MODE)
      $certFile = __DIR__.'/apple-certs/ProPushProduction.pem';
    else
      $certFile = __DIR__.'/apple-certs/ProPushDev.pem';

    $sender   =  $this->createSender($certFile);

    if(!$sender)
      return false;

    $this->_senderProApp = $sender;
    return $this->_senderProApp;
  }

  function createSender($certfilePath){
    if(!file_exists($certfilePath)){
      $this->_lastError = new Exception("File not found at {$certfilePath}");
      return false;
    }

    try{
      $env = ($this->_mode == self::PRODUCTION_MODE)
              ? ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION
              : ApnsPHP_Abstract::ENVIRONMENT_SANDBOX;

      $sender = new ApnsPHP_Push(
                  $env,
                  $certfilePath
                );
    }catch( Exception $e ){
      $this->_lastError = $e;
      return false;
    }
    return $sender;
  }


  function getView($name,$data){
    $viewPath = "notifications.push.{$name}";

    if(!view()->exists($viewPath)){
      $this->_lastError = new Exception("View not found at {$viewPath}");
      return false;
    }
    return view($viewPath, $data);
  }

  function toCustomer($userId, $name, Array $data = [], Array $custom = []){
   
    $view = $this->getView($name,$data);
    if(!$view)
      return false;

    $settings = Models\CustomerSettings::findByUserId($userId);
    if(!$settings->notifications){
      $this->_lastError = new Exception("User disabled notifications");
      return false;
    }

    $deviceToken = DB::table('customers')->where('user_id', $userId)->value('apple_device_token');
    if(!$deviceToken){
      $this->_lastError = new Exception("Device token not found for customerId {$userId}");
      return false;
    }

    $sender = $this->senderConsumerApp();
    if(!$sender)
      return false;

    return $this->toDevice($sender, $deviceToken,$view , $custom);
  }

  function toTech($userId, $name, Array $data = [], Array $custom = []){
    $view = $this->getView($name,$data);
    if(!$view)
      return false;

    $deviceToken = DB::table('technicians')->where('user_id', $userId)->value('apple_device_token');
    if(!$deviceToken){
      $this->_lastError = new Exception("Device token not found for customerId {$userId}");
      return false;
    }

    $sender = $this->senderProApp();
    if(!$sender)
      return false;

    return $this->toDevice($sender, $deviceToken,$view , $custom);
  }

  function toPro($userId, $name, Array $data = [], Array $custom = []){
    return $this->toTech($userId, $name, $data, $custom);
  }

  function toDevice( ApnsPHP_Push $sender, $deviceToken, $body, Array $custom = []){
    try{
     
      $sender->connect();
      $message = new ApnsPHP_Message($deviceToken);
      if(strlen($body))
          $message->setText(trim($body));
      foreach($custom as $key => $value)
        $message->setCustomProperty($key, $value);
      $message->setSound();
      $sender->add($message);
      $response = $sender->send();
    }catch( Exception $e ){
      $this->_lastError = $e;
        return false;
    }
    return true;
  }

  function toBulkDevices( ApnsPHP_Push $sender, $messages){
    try{
      $sender->connect();
      foreach($messages as $message){
        $message->setSound();
        $sender->add(trim($message));
      }

      $response = $sender->send();
      $sender->disconnect();
    }catch( Exception $e ){
      $this->_lastError = $e;
      \Log::error($e);
      return false;
    }
    return true;
  }

}
