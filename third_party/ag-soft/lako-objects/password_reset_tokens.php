<?php

lako::get('objects')->add_config('password_reset_tokens', [
    'table'     => 'password_reset_tokens',
    'name'      => 'password_reset_tokens',
    'pkey'      => 'id',
    'fields'    => [],
    'relations' => []
]);