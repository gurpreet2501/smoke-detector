<?php
lako::get('objects')->add_config('users', [
    'table'     => 'users',
    'name'      => 'users',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
        'technicians' => [
            'type'    => '1-1',
            'path'    => ['id','user_id'],
            'object'  => 'technicians',
            'holds_foreign_key'  => 0,
        ],
        'pros' => [
            'type'    => '1-1',
            'path'    => ['id','user_id'],
            'object'  => 'pros',
            'holds_foreign_key'  => 0,
        ],
        'customers' => [
            'type'    => '1-1',
            'path'    => ['id','user_id'],
            'object'  => 'customers',
            'holds_foreign_key'  => 0,
        ],
        'services' => [
            'type'    => 'N-M',
            'path'    => ['id','user_id','service_id','id'],
            'object'  => 'services',
            'connection_table'  => 'user_services',
        ],
        'customer_addresses' => [
            'type'    => '1-M',
            'path'    => ['id', 'user_id'],
            'object'  => 'customer_addresses',
            'holds_foreign_key'  => 0,
        ],
        'pro_settings' => [
            'type'    => '1-1',
            'path'    => ['id','user_id'],
            'object'  => 'pro_settings',
            'holds_foreign_key'  => 0,
        ],
        'customer_settings' => [
            'type'    => '1-1',
            'path'    => ['id','user_id'],
            'object'  => 'customer_settings',
            'holds_foreign_key'  => 0,
        ],
        'quickblox_accounts' => [
            'type'    => '1-1',
            'path'    => ['id','user_id'],
            'object'  => 'quickblox_accounts',
            'holds_foreign_key'  => 0,
        ],

        'user_cards' => [
            'type'    => '1-M',
            'path'    => ['id','user_id'],
            'object'  => 'user_cards',
            'holds_foreign_key'  => 0,
        ],

        'trade_licenses' => [
            'type'    => '1-M',
            'path'    => ['id','user_id'],
            'object'  => 'trade_licenses',
            'holds_foreign_key'  => 0,
        ],
    ]
]);
