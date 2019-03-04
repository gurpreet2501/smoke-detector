<?php

namespace App\Notifications\Push;

use DB;
use App\Models;
use Log;
use App\Libs\Firebase;
class AndroidService implements Interfaces\Service
{
    private $_lastError, $key, $firebaseClient;

    function __construct($key)
    {
        $this->key = $key;
        $this->firebaseClient = new Firebase\Firebase($key);
    }

    function buildPush($text,$data){
      $push = new Firebase\Push();
      $push->setMessage($text);
      $push->setPayload($data);
      return $push;
    }

    // https://developers.google.com/cloud-messaging/http-server-ref#downstream-http-messages-json
    public function toDevice($deviceId, $text, Array $customData = [])
    {    
        $pushData = $this->buildPush($text,$customData)->getPush();
        $this->firebaseClient->send($deviceId,$pushData);
        return true; 
    }

    public function toBulkDevices(Array $collection)
    {
        extract($collection);

        if (!isset($deviceIds) || !isset($text) || !isset($customData))
        {
           $this->_lastError = new Exception('Collection is Missing some index');
           return false;
        }
        $pushData = $this->buildPush($text,$customData)->getPush();
        $this->firebaseClient->sendMultiple($deviceIds,$pushData);
        return true; 
    }

    public function lastError()
    {
        return $this->_lastError;
    }
}
