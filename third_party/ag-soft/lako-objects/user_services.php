<?php

lako::get('objects')->add_config('user_services', [
    'table'     => 'user_services',
    'name'      => 'user_services',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
        'users' => [
            'type'    => '1-1',
            'path'    => ['user_id', 'id'],
            'object'  => 'users',
            'holds_foreign_key'  => 0,
        ]
    ]
]);