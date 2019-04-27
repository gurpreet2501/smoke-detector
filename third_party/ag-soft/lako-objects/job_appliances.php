<?php
lako::get('objects')->add_config('job_appliances',array(
    'table'     => 'job_appliances',
    'name'      => 'job_appliances',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
        'jobs' => [
            'type'    => 'M-1',
            'path'    => ['job_id', 'id'],
            'object'  => 'jobs',
            'holds_foreign_key'  => 0,
        ],

        'job_appliance_line_items' => [
            'type'    => '1-M',
            'path'    => ['id', 'job_appliance_id'],
            'object'  => 'jobs',
        ],

        'appliance_types' => [
            'type'    => '1-1',
            'path'    => ['appliance_id', 'id'],
            'object'  => 'appliance_types',
            'holds_foreign_key'  => 0,
        ],
        'canceled_job_appliances' => [
            'type'    => '1-1',
            'path'    => ['id', 'job_appliance_id'],
            'object'  => 'canceled_job_appliances',
            'holds_foreign_key'  => 0,
        ],

        'job_appliance_install_info' => [
            'type'    => '1-1',
            'path'    => ['id', 'job_appliance_id'],
            'object'  => 'job_appliance_install_info',
            'holds_foreign_key'  => 0,
        ],

        'job_appliance_repair_whats_wrong' => [
            'type'    => '1-1',
            'path'    => ['id', 'job_appliance_id'],
            'object'  => 'job_appliance_repair_whats_wrong',
            'holds_foreign_key'  => 0,
        ],

        'equipment_info' => [
            'type'    => '1-1',
            'path'    => ['id', 'job_appliance_id'],
            'object'  => 'equipment_info',
            'holds_foreign_key'  => 0,
        ],

        'job_appliance_maintain_info' => [
            'type'    => '1-1',
            'path'    => ['id', 'job_appliance_id'],
            'object'  => 'job_appliance_maintain_info',
            'holds_foreign_key'  => 0,
        ],

        'job_parts_used' => [
            'type'    => '1-M',
            'path'    => ['id', 'job_appliance_id'],
            'object'  => 'job_parts_used',
            'holds_foreign_key'  => 0,
        ],

        'equipment_images' => [
            'type'    => '1-M',
            'path'    => ['id', 'job_appliance_id'],
            'object'  => 'job_appliance_equipment_images',
        ],

        'job_appliance_install_types' => [
            'type'    => '1-1',
            'path'    => ['id','job_appliance_id'],
            'object'  => 'job_appliance_install_types',
            'holds_foreign_key'  => 0,
        ],

        'job_appliance_maintain_types' => [
            'type'    => '1-1',
            'path'    => ['id','job_appliance_id'],
            'object'  => 'job_appliance_maintain_types',
            'holds_foreign_key'  => 0,
        ],

        'job_appliance_repair_types' => [
            'type'    => '1-1',
            'path'    => ['id','job_appliance_id'],
            'object'  => 'job_appliance_repair_types',
            'holds_foreign_key'  => 0,
        ],


        'appliance_types_variations' => [
            'type'    => '1-1',
            'path'    => ['appliance_type_variation_id','id'],
            'object'  => 'appliance_types_variations',
            'holds_foreign_key'  => 1,
        ],

    ]
));
