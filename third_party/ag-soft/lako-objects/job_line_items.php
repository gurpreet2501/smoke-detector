<?php
lako::get('objects')->add_config('job_line_items',array(
    'table'     => 'job_line_items',
    'name'      => 'job_line_items',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [

        // 'appliance_types' => [
        //     'type'    => '1-1',
        //     'path'    => ['appliance_type_id', 'id'],
        //     'object'  => 'appliance_types',
        //     'holds_foreign_key'  => 0,
        // ],

    ]
));
