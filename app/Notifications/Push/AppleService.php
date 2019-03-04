<?php

namespace App\Notifications\Push;

use DB;
use \ApnsPHP_Push;
use \ApnsPHP_Abstract;
use \ApnsPHP_Message;
use \Exception;
use App\Models;

require_once __DIR__ .'/../../../third_party/ApnsPHP/Autoload.php';

class AppleService implements Interfaces\Service
{
    private $env;
    private $_sender,
            $_lastError = null;

    const PRODUCTION_MODE = 'PRODUCTION';
    const SANDBOX_MODE    = 'SANDBOX';

    function __construct($env,$cert)
    {
        $this->env = $env;
        $this->cert = $cert;
    }

    public function toDevice($deviceId, $text, Array $customData = [], $badge =-1)
    {
        
        $sender = $this->getSender();
       
        if(!$sender)
            return false;

        try
        {
            $sender->connect();
            $sender->add($this->buildMessage($deviceId, $text, $customData, $badge));
            $resp = $sender->send();
          
            $sender->disconnect();
        }
        catch(Exception $e)
        {
            $this->_lastError = $e;
          
            return false;
        }

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

        $sender = $this->getSender();
        if(!$sender)
        {
            $this->_lastError = new Exception('Unable to create sender');
            return false;
        }

        try
        {
            $sender->connect();
            foreach ($deviceIds as $deviceId){
                $message = $this->buildMessage($deviceId, 
                                                $text, 
                                                $customData, 
                                                $badge);
                $sender->add($message);
            }
                

            $sender->send();
            $sender->disconnect();
        }
        catch(Exception $e)
        {
            $this->_lastError = $e;
            return false;
        }

        return true;
    }

    private function getSender()
    {
        if ($this->_sender !== null)
            return $this->_sender;
        
        $cartFile =  __DIR__ . '/apple-certs/' . $this->cert ;

        if(!file_exists($cartFile))
        {
            $this->_lastError = new Exception("File not found at {$cartFile}");
            return false;
        }

        try
        {
            $env = ($this->env==self::PRODUCTION_MODE)
                    ? ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION
                    : ApnsPHP_Abstract::ENVIRONMENT_SANDBOX;
            $sender = new ApnsPHP_Push($env, $cartFile);
            
        }
        catch(Exception $e)
        {
            $this->_lastError = $e;
            return false;
        }

        $this->_sender = $sender;
        return $this->_sender;
    }

    private function buildMessage($deviceId, $text, $customData, $badge=-1)
    {
        $message = new ApnsPHP_Message($deviceId);
        $message->setText(trim($text));

        foreach($customData as $key => $value)
            $message->setCustomProperty($key, $value);

        if($badge>0){            
            $message->setBadge($badge);
        }

        if(strlen(trim($text)))
            $message->setSound();
        return $message;
    }

    public function lastError()
    {
        return $this->_lastError;
    }
}
