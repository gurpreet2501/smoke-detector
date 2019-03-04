<?php

lako::get('objects')->add_config('services', [
    'table'     => 'services',
    'name'      => 'services',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
      'brands' => [
        'type'    => 'N-M',
        'path'    => ['id','service_id','brand_id','id'],
        'object'  => 'brands',
        'connection_table'  => 'services_brands',
      ],
    ]
]);
