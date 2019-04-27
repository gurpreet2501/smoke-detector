<?php 

namespace App\Notifications\Push\Interfaces;

interface Client
{
    public function toCustomer($userId, $view, Array $viewData = [], Array $customData = [], $jobId = 0);
    public function toTech($userId, $view, Array $viewData = [], Array $customData = [], $jobId = 0);
    public function toPro($userId, $view, Array $viewData = [], Array $customData = [], $jobId = 0);
    public function toDevice(Array $deviceTokens, $text, Array $customData = [], $userId, $appVersion);
}
