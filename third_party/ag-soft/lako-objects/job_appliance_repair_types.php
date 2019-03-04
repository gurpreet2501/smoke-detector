<?php
lako::get('objects')->add_config('job_appliance_repair_types',array(
    'table'     => 'job_appliance_repair_types',
    'name'      => 'job_appliance_repair_types',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
      'repair_types' => [
        'type'    => '1-1',
        'path'    => ['repair_type_id', 'id'],
        'object'  => 'repair_types',
        'holds_foreign_key'  => 1,
      ]
    ]
));