<?php
lako::get('objects')->add_config('alerts', [
    'table'     => 'alerts',
    'name'      => 'alerts',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
      'alerts_data' => [
        'type'    => '1-M',
        'path'    => ['id','alert_id'],
        'object'  => 'alerts_data'
      ],
    ]
]);
