<?php
lako::get('objects')->add_config('pros', [
    'table'     => 'pros',
    'name'      => 'pros',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
        'users' => [
            'type'    => '1-1',
            'path'    => ['user_id', 'id'],
            'object'  => 'users',
            'holds_foreign_key'  => 1,
        ],
         'zipcodes' => [
            'type'    => '1-1',
            'path'    => ['zip', 'zipcode'],
            'object'  => 'zipcodes',
            'holds_foreign_key'  => 0,
        ]
    ]
]);
