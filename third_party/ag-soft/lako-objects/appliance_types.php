<?php
lako::get('objects')->add_config('appliance_types', [
    'table'     => 'appliance_types',
    'name'      => 'appliance_types',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
        'services' => [
            'type'    => '1-1',
            'path'    => ['service_id','id'],
            'object'  => 'services',
        ],
        'repair_types' => [
            'type'    => 'N-M',
            'path'    => ['id','appliance_id','repair_id','id'],
            'object'  => 'repair_types',
            'connection_table'  => 'appliance_types_repair_types',
        ],
        'install_types' => [
          'type'    => 'N-M',
          'path'    => ['id','appliance_id','installtype_id','id'],
          'object'  => 'install_types',
          'connection_table'  => 'appliance_types_install_types',
        ],
        'maintain_types' => [
            'type'    => 'N-M',
            'path'    => ['id','appliance_id','maintain_id','id'],
            'object'  => 'maintain_types',
            'connection_table'  => 'appliance_types_maintain_types',
        ],
        'appliance_types_variations' => [
          'type'    => '1-M',
          'path'    => ['id','appliance_type_id'],
          'object'  => 'appliance_types_variations'
        ],
    ],
]);
