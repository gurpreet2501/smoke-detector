<?php 

namespace App\Notifications\Push\Interfaces;

interface Service 
{
    public function toDevice($deviceId, $text, Array $customData = []);
    public function toBulkDevices(Array $collection);
}