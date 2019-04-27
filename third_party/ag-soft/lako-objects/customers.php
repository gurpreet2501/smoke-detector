<?php
lako::get('objects')->add_config('customers', [
    'table'     => 'customers',
    'name'      => 'customers',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
        'users' => [
            'type'    => '1-1',
            'path'    => ['user_id', 'id'],
            'object'  => 'users',
            'holds_foreign_key'  => 0,
        ],
        'customer_addresses' => [
            'type'    => '1-M',
            'path'    => ['user_id', 'user_id'],
            'object'  => 'customer_addresses',
            'holds_foreign_key'  => 0,
        ]
    ]
]);