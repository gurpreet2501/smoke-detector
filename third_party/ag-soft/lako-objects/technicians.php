<?php
lako::get('objects')->add_config('technicians', [
    'table'     => 'technicians',
    'name'      => 'technicians',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
        'users' => [
            'type'    => '1-1',
            'path'    => ['user_id', 'id'],
            'object'  => 'users',
            'holds_foreign_key'  => 1,
        ],
        'pro' => [
            'type'    => 'M-1',
            'path'    => ['added_by', 'id'],
            'object'  => 'users',
            'holds_foreign_key'  => 1,
        ],
        'pro_profile' => [
            'type'    => 'M-1',
            'path'    => ['added_by', 'user_id'],
            'object'  => 'pros',
            'holds_foreign_key'  => 1,
        ],
    ]
]);
