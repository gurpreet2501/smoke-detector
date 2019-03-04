<?php
lako::get('objects')->add_config('job_customer_addresses',array(
    'table'     => 'job_customer_addresses',
    'name'      => 'job_customer_addresses',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
      'jobs' => [
            'type'    => '1-1',
            'path'    => ['job_id', 'id'],
            'object'  => 'jobs',
            'holds_foreign_key'  => 0,
        ]
    ]
));