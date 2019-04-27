<?php

lako::get('config')->add_config('database',array(
  'username' => \Config::get('database.connections.mysql.username'),
  'database' => \Config::get('database.connections.mysql.database'),
  'password' => \Config::get('database.connections.mysql.password'),
  'host'     => \Config::get('database.connections.mysql.host'),
  'table_prefix'  => '',
  'table_suffix'  => '',
));
