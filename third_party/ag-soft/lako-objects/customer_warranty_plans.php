<?php
lako::get('objects')->add_config('customer_warranty_plans', [
    'table'     => 'customer_warranty_plans',
    'name'      => 'customer_warranty_plans',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
    'warranty_plans' => [
            'type'    => '1-1',
            'path'    => ['warranty_plan_id','id'],
            'object'  => 'warranty_plans',
            'holds_foreign_key'  => 0,
        ],
    'customer_addresses' => [
            'type'    => '1-1',
            'path'    => ['customer_address_id','id'],
            'object'  => 'customer_addresses',
            'holds_foreign_key'  => 1,
        ],
    ]
]);
