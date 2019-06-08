<?php

namespace App\Notifications\Push;

use DB;
use \Exception;
use App\Models;
use Log;


class Client implements Interfaces\Client
{
    const CUSTOMER_APP    = 'CUSTOMER_APP';
    const PRO_APP         = 'PRO_APP';

    public $syncWithDB = true;

    private $customerAppleService,
            $proAppleService,
            $customerAndroidService,
            $proAndroidService;

    function __construct($customerAppleService, $proAppleService, $customerAndroidService, $proAndroidService)
    {
        $this->proAppleService        = $proAppleService;
        $this->proAndroidService      = $proAndroidService;
        $this->customerAppleService   = $customerAppleService;
        $this->customerAndroidService = $customerAndroidService;
    }

    public function toCustomer($userId, $name, Array $viewData = [], Array $customData = [], $jobId = 0)
    {
      
       
        $view = $this->getView($name, $viewData);
       
        
        if(!$view)
            return false;
       

        $deviceToken = Models\Users::select(['device_id','device_type'])
                                       ->where('id', $userId)
                                       ->first();
         
        if(is_null($deviceToken))
        {
            $this->_lastError = new Exception("Device token not found for customerId {$userId}");
            return false;
        }
     
        return $this->toDevice($deviceToken->toArray(), $view->render(), $customData, $userId, self::CUSTOMER_APP, $jobId);
    }

    public function toTech($userId, $name, Array $viewData = [], Array $customData = [], $jobId = 0)
    {
        $view = $this->getView($name, $viewData);
        if(!$view)
            return false;

        $deviceToken = Models\Technicians::select(['apple_device_token', 'gcm_token'])
                         ->where('user_id', $userId)->first();
        if(is_null($deviceToken))
        {
            $this->_lastError = new Exception("Device token not found for technicianId {$userId}");
            return false;
        }

        return $this->toDevice($deviceToken->toArray(), $view->render(), $customData, $userId, self::PRO_APP, $jobId);
    }

    public function toPro($userId, $name, Array $viewData = [], Array $customData = [], $jobId = 0)
    {
        return $this->toTech($userId, $name, $viewData, $customData, $jobId);
    }

    public function lastError()
    {
        return $this->_lastError;
    }

    public function getView($name, $data)
    {
        $path = "notifications.push.{$name}";

        if(!view()->exists($path))
        {
            $this->_lastError = new Exception("View not found at {$path}");
            return false;
        }

        return view($path, $data);
    }

    function saveInDB($userId, $text, $customData, $jobId = 0)
    {
        if($this->syncWithDB)
            Models\Alerts::createFromApn($userId, $text, $customData, $jobId);
    }

    public function toDevice(Array $tokens, $text, Array $customData = [], $userId, $appInfo, $jobId = 0)
    {

   
        $text = $this->trim($text);
       
        // $this->saveInDB($userId, $text, $customData, $jobId);
        try{

            $resp1 = true;
        
            if (!empty($tokens['device_id'])  && $tokens['device_type'] == 'IOS')
            {
                    
                $service = $this->proAppleService;
           
                $resp1 = $service->toDevice(
                    $tokens['device_id'],
                    $text,
                    $customData,
                    ''
                );
             
                if (!$resp1)
                    $this->_lastError = $service->lastError();

             
            }
         
            $resp2 = true;
            if (!empty($tokens['device_id']) && $tokens['device_type'] == 'ANDROID')
            {
                
                $service = $this->customerAndroidService;
               
                $resp2 = $service->toDevice($tokens['device_id'], $text, $customData);
                
                if (!$resp2){
                    $this->_lastError = $service->lastError();
                }
            }

          return ($resp1 && $resp2);

        }catch(Exception $e){
           return false;
        }
      
      return true;
        
    }

    /**
     * @param Array $collection [
     *  'androidDeviceIds'  => [], // list of android tokens
     *  'appleDeviceIds'    => [], // list of apple tokens
     *  'userIds'           => [], // list of user that will get alerts
     *  'text'              => '', // alert text
     *  'customData'        => [] // alert custom data
     *  'jobId'             => 0
     * ]
     * @param $appInfo const value for app type
     */
    public function toBulkDevices(Array $collection, $appInfo)
    {
        extract($collection);

        $idsDontExists = (!isset($appleDeviceIds) && !isset($androidDeviceIds));
        if ($idsDontExists || !isset($text) || !isset($customData) || !isset($userIds))
        {
           $this->_lastError = new Exception('Collection is missing few index');
           return false;
        }
        $jobId = isset($jobId) ? $jobId : 0;
        $text = $this->trim($text);

        // create alerts
        foreach ($userIds as $userId)
            $this->saveInDB($userId, $text, $customData, $jobId);

        $resp1 = true;
        if (isset($appleDeviceIds) && !empty($appleDeviceIds))
        {
            $service = ($appInfo == self::PRO_APP) ? $this->proAppleService : $this->customerAppleService;
            $resp1 = $service->toBulkDevices([
                'deviceIds'  => $appleDeviceIds,
                'text'       => $text,
                'customData' => $customData,
                'badge'      => isset($badge) ?$badge :-1,
            ]);
        }

        $resp2 = true;
        if (isset($androidDeviceIds) && !empty($androidDeviceIds))
        {
            $service = ($appInfo == self::PRO_APP) ? $this->proAndroidService : $this->customerAndroidService;
            Log::debug('Sending bulk android.');
            $resp2 = $service->toBulkDevices([
                'deviceIds'  => $androidDeviceIds,
                'text'       => $text,
                'customData' => $customData,
                'badge'      => isset($badge) ?$badge :-1,
            ]);
        }

        return ($resp1 && $resp2);
    }

    private function trim($text)
    {
        return trim(preg_replace('/\s+/', ' ', $text));
    }

}
