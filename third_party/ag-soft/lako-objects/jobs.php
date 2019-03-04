<?php
lako::get('objects')->add_config('jobs',array(
    'table'     => 'jobs',
    'name'      => 'jobs',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
        'time_slots' => [
            'type'    => '1-1',
            'path'    => ['time_slot_id', 'id'],
            'object'  => 'time_slots',
            'holds_foreign_key'  => 0,
        ],
        // 'appliance_types' => [
        //     'type'    => '1-1',
        //     'path'    => ['appliance_type_id', 'id'],
        //     'object'  => 'appliance_types',
        //     'holds_foreign_key'  => 0,
        // ],

        'job_appliances' => [
            'type'    => '1-M',
            'path'    => ['id', 'job_id'],
            'object'  => 'job_appliances',
            'holds_foreign_key'  => 0,
        ],
        'job_pictures' => [
            'type'    => '1-M',
            'path'    => ['id', 'job_id'],
            'object'  => 'job_pictures',
            'holds_foreign_key'  => 0,
        ],
        'job_parts_used' => [
            'type'    => '1-M',
            'path'    => ['id', 'job_id'],
            'object'  => 'job_parts_used',
            'holds_foreign_key'  => 0,
        ],
        'job_customer_addresses' => [
            'type'    => '1-1',
            'path'    => ['id', 'job_id'],
            'object'  => 'job_customer_addresses',
            'holds_foreign_key'  => 0,
        ],
        'technicians' => [
            'type'    => '1-1',
            'path'    => ['technician_id', 'user_id'],
            'object'  => 'technicians',
            'holds_foreign_key'  => 0,
        ],

        'pros' => [
            'type'    => '1-1',
            'path'    => ['pro_id', 'user_id'],
            'object'  => 'pros',
            'holds_foreign_key'  => 1,
        ],
        'customers' => [
            'type'    => '1-1',
            'path'    => ['customer_id', 'user_id'],
            'object'  => 'customers',
            'holds_foreign_key'  => 1,
        ],

        'job_images' => [
            'type'    => '1-M',
            'path'    => ['id', 'job_id'],
            'object'  => 'job_images',
        ],

        'job_repair' => [
          'type'    => '1-1',
          'path'    => ['id', 'job_id'],
          'object'  => 'job_repair',
          'holds_foreign_key'  => 0,
        ],

        'tech_routes' => [
          'type'    => '1-1',
          'path'    => ['id', 'job_id'],
          'object'  => 'tech_routes',
          'holds_foreign_key'  => 0,
        ],

        'technicians_ratings' => [
          'type'    => '1-1',
          'path'    => ['id', 'job_id'],
          'object'  => 'technicians_ratings',
          'holds_foreign_key'  => 0,
        ],

        'job_payment_details' => [
          'type'    => '1-1',
          'path'    => ['id', 'job_id'],
          'object'  => 'job_payment_details',
          'holds_foreign_key'  => 0,
        ],
        
        'job_line_items' => [
          'type'    => '1-1',
          'path'    => ['id', 'job_id'],
          'object'  => 'job_line_items',
          'holds_foreign_key'  => 0,
        ],

        'pros_tech_fields' => [
            'type'    => '1-1',
            'path'    => ['pro_id', 'user_id'],
            'object'  => 'technicians',
            'holds_foreign_key'  => 0,
        ],
    ]
));
