<?php
lako::get('objects')->add_config('job_appliance_install_types',array(
    'table'     => 'job_appliance_install_types',
    'name'      => 'job_appliance_install_types',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
      'install_types' => [
          'type'    => '1-1',
          'path'    => ['install_type_id', 'id'],
          'object'  => 'install_types',
          'holds_foreign_key'  => 1,
        ]
    ]
));