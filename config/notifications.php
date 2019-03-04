<?php

use App\Notifications\Push\AppleService;

return [
    'push' => [
        'apple' => [
            'env' => AppleService::SANDBOX_MODE,
            'proCert'       => 'Certificates_ySkolar.pem',//'ProPushDev.pem',
        ],
        'android' => [
            'customer_app'  => ['key' => 'AAAA7yL_BYo:APA91bEUK9Lqk8dCv2g8hDvmqKx9Y6u_IYZxWC5VE2iP8vdftlFqnAUXooJ2M5E2w-KfpnFjD8aca8U0VWiVpq98CotB_unUxViFjm6bCAA8gTqAmvLDlBblm5s9-hdqFLZKxSAEm-k2'],
        ],
    ]

   



];
