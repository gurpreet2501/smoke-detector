<?php
lako::get('objects')->add_config('job_appliance_maintain_types',array(
    'table'     => 'job_appliance_maintain_types',
    'name'      => 'job_appliance_maintain_types',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
      'maintain_types' => [
          'type'    => '1-1',
          'path'    => ['maintain_type_id', 'id'],
          'object'  => 'maintain_types',
          'holds_foreign_key'  => 1,
        ]
    ]
));
