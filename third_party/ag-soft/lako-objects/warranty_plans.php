<?php
lako::get('objects')->add_config('warranty_plans', [
    'table'     => 'warranty_plans',
    'name'      => 'warranty_plans',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
        'appliance_types' => [
            'type'    => 'N-M',
            'path'    => ['id','warranty_plan_id','appliance_type_id','id'],
            'object'  => 'appliance_types',
            'connection_table'  => 'warranty_plans_appliance_types',
        ],
        'simple_plans' => [
            'type'    => 'N-M',
            'path'    => ['id','combined_plan_id','simple_plan_id','id'],
            'object'  => 'warranty_plans',
            'connection_table'  => 'combined_plans_simple_plans',
        ],
        'warranty_items' => [
            'type'    => 'N-M',
            'path'    => ['id','warranty_plan_id','warranty_item_id','id'],
            'object'  => 'warranty_items',
            'connection_table'  => 'warranty_plans_warranty_items',
        ]
    ]
]);
