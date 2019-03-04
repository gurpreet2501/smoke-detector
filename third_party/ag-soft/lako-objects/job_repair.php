<?php
lako::get('objects')->add_config('job_repair',array(
    'table'     => 'job_repair',
    'name'      => 'job_repair',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
      'jobs' => [
            'type'    => '1-1',
            'path'    => ['job_id', 'id'],
            'object'  => 'jobs',
            'holds_foreign_key'  => 1,
        ],
        'repair_types' => [
            'type'    => 'M-1',
            'path'    => ['repair_type_id', 'id'],
            'object'  => 'repair_types',
            'holds_foreign_key'  => 0,
        ],
        'appliance_types' => [
            'type'    => 'M-1',
            'path'    => ['appliance_type_id', 'id'],
            'object'  => 'appliance_types',
            'holds_foreign_key'  => 0,
        ],
    ]
));