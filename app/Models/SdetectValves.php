<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SdetectValves extends Model
{
    protected $table = 'sdetect_valves';

    protected $fillable = [
        'name',
        'serial_id',
        'home_id',
        'floor_id',
        'valve_status',
        'user_id',

    ];

     protected $rules = [
      
	];

	  protected $validationMessages = [
      
        ];

     public $timestamps = true;

 
}
