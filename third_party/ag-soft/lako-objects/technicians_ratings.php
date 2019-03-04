<?php
lako::get('objects')->add_config('technicians_ratings', [
    'table'     => 'technicians_ratings',
    'name'      => 'technicians_ratings',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
        'jobs' => [
            'type'    => '1-1',
            'path'    => ['job_id', 'id'],
            'object'  => 'jobs',
            'holds_foreign_key'  => 0,
        ],
        'customers' => [
            'type'    => '1-1',
            'path'    => ['customer_id','user_id'],
            'object'  => 'customers',
            'holds_foreign_key'  => 0,
        ],
        'technicians' => [
            'type'    => 'M-1',
            'path'    => ['technician_id','user_id'],
            'object'  => 'technicians',
        ],
    ]
]);