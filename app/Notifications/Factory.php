<?php

namespace App\Notifications;

use App\Notifications\Push\Client as PushClient;
use App\Notifications\SMS\Twilio;
use App\Notifications\Email\Mandrill;
use Exception;

class Factory
{
  private static $collection = [];

  public static function push()
  {
    if (isset(self::$collection['push'])) {
      return self::$collection['push'];
    }

    $env = config('notifications.push.apple.env');
    self::$collection['push'] = new PushClient(
      new Push\AppleService($env, config('notifications.push.apple.consumerCert')),
      new Push\AppleService($env, config('notifications.push.apple.proCert')),
      new Push\AndroidService(config('notifications.push.android.customer_app.key')),
      new Push\AndroidService(config('notifications.push.android.pro_app.key'))
      );

    return self::$collection['push'];
  }


  public static function dispatch($dispatcherClass)
  {
    $parts = explode(';', $dispatcherClass);
    //legacy format
    if(count($parts) == 1)
      $className = Dispatchers::class.'\\'.$dispatcherClass;
    //new format
    elseif(count($parts) == 3){
      list($companyId, $appId, $class) = $parts;
      $appClassName = Dispatchers::class.'\\'.implode('\\', $parts);
      $companyClassName = Dispatchers::class.'\\'.$companyId.'\\'.$class;

     if(class_exists($appClassName))
        $className = $appClassName;
      elseif(class_exists($companyClassName))
        $className = $companyClassName;
      else
        $className = Dispatchers::class.'\\'.$class;
    }
    else
      throw new Exception('Invalid Dispatcher class name format.');

    $class = new \ReflectionClass($className);
    $arguments = array_slice(func_get_args(), 1);
    $instance = $class->newInstanceArgs($arguments);
    $instance->send();
  }
}
