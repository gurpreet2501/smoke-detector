<?php
lako::get('objects')->add_config('wrranty_orders', [
    'table'     => 'wrranty_orders',
    'name'      => 'wrranty_orders',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => [
	    'warranty_plans' => [
	    	'type'    => 'N-M',
            'path'    => ['id','wrranty_order_id','plan_id','id'],
            'object'  => 'warranty_plans',
            'connection_table'  => 'order_wrranty_plans',
        ],
     ]
]);