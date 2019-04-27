<?php 

namespace App\Notifications\Push;

use \PHP_GCM\Constants;
use \PHP_GCM\MulticastResult;
use \PHP_GCM\Result;
use \PHP_GCM\Message;
use \PHP_GCM\InvalidRequestException;

class PHP_GCM_Sender extends \PHP_GCM\Sender
{
    private $key;
    public function __construct($key) 
    {
        $this->key = $key;
        parent::__construct($key);
    }
    public function sendNoRetry(Message $message, $registrationId) 
    {
        if(empty($registrationId))
            throw new \InvalidArgumentException('registrationId can\'t be empty');

        $body = Constants::$PARAM_REGISTRATION_ID . '=' . $registrationId;

        $delayWhileIdle = $message->getDelayWhileIdle();
        if(!is_null($delayWhileIdle))
            $body .= '&' . Constants::$PARAM_DELAY_WHILE_IDLE . '=' . ($delayWhileIdle ? '1' : '0');

        $collapseKey = $message->getCollapseKey();
        if($collapseKey != '')
            $body .= '&' . Constants::$PARAM_COLLAPSE_KEY . '=' . $collapseKey;

        $timeToLive = $message->getTimeToLive();
        if($timeToLive != -1)
            $body .= '&' . Constants::$PARAM_TIME_TO_LIVE . '=' . $timeToLive;

        foreach($message->getData() as $key => $value) {
            $body .= '&' . Constants::$PARAM_PAYLOAD_PREFIX . $key . '=' . urlencode($value);
        }

        $headers = array('Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
                            'Authorization: key=' . $this->key);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, Constants::$GCM_SEND_ENDPOINT);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status == 503)
            return null;
        if($status != 200)
            throw new InvalidRequestException($status);
        if($response == '')
            throw new \Exception('Received empty response from GCM service.');

        $lines = explode("\n", $response);
        $responseParts = explode('=', $lines[0]);
        $token = $responseParts[0];
        $value = $responseParts[1];
        if($token == Constants::$TOKEN_MESSAGE_ID) {
            $result = new Result();
            $result->setMessageId($value);

            if(isset($lines[1]) && $lines[1] != '') {
                $responseParts = explode('=', $lines[1]);
                $token = $responseParts[0];
                $value = $responseParts[1];

                if($token == Constants::$TOKEN_CANONICAL_REG_ID)
                    $result->setCanonicalRegistrationId($value);
            }

            return $result;
        } else if($token == Constants::$TOKEN_ERROR) {
            $result = new Result();
            $result->setErrorCode($value);
            return $result;
        } else {
            throw new \Exception('Received invalid response from GCM: ' . $lines[0]);
        }
    }


    public function sendNoRetryMulti(Message $message, array $registrationIds) {
        if(is_null($registrationIds) || count($registrationIds) == 0)
            throw new \InvalidArgumentException('registrationIds cannot be null or empty');

        $request = array();

        if($message->getTimeToLive() != -1)
            $request[Constants::$PARAM_TIME_TO_LIVE] = $message->getTimeToLive();

        if($message->getCollapseKey() != '')
            $request[Constants::$PARAM_COLLAPSE_KEY] = $message->getCollapseKey();

        if($message->getDelayWhileIdle() != '')
            $request[Constants::$PARAM_DELAY_WHILE_IDLE] = $message->getDelayWhileIdle();

        $request[Constants::$JSON_REGISTRATION_IDS] = $registrationIds;

        if(!is_null($message->getData()) && count($message->getData()) > 0)
            $request[Constants::$JSON_PAYLOAD] = $message->getData();

        $request = json_encode($request);

        $headers = array('Content-Type: application/json',
            'Authorization: key=' . $this->key);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, Constants::$GCM_SEND_ENDPOINT);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status != 200)
            throw new InvalidRequestException($status, $response);

        $response = json_decode($response, true);
        $success = $response[Constants::$JSON_SUCCESS];
        $failure = $response[Constants::$JSON_FAILURE];
        $canonicalIds = $response[Constants::$JSON_CANONICAL_IDS];
        $multicastId = $response[Constants::$JSON_MULTICAST_ID];

        $multicastResult = new MulticastResult($success, $failure, $canonicalIds, $multicastId);

        if(isset($response[Constants::$JSON_RESULTS])){
            $individualResults = $response[Constants::$JSON_RESULTS];

            foreach($individualResults as $singleResult) {
                $messageId = isset($singleResult[Constants::$JSON_MESSAGE_ID]) ? $singleResult[Constants::$JSON_MESSAGE_ID] : null;
                $canonicalRegId = isset($singleResult[Constants::$TOKEN_CANONICAL_REG_ID]) ? $singleResult[Constants::$TOKEN_CANONICAL_REG_ID] : null;
                $error = isset($singleResult[Constants::$JSON_ERROR]) ? $singleResult[Constants::$JSON_ERROR] : null;

                $result = new Result();
                $result->setMessageId($messageId);
                $result->setCanonicalRegistrationId($canonicalRegId);
                $result->setErrorCode($error);

                $multicastResult->addResult($result);
            }
        }

        return $multicastResult;
    }

}