<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = 'sdetect_machines';

    protected $fillable = [
        'name',
        'serial_no',
        'carbon_monoxide',
        'lpg',
        'smoke',
        'air_purity',
        'temperature',
        'humidity',
        'token',
        'user_id',
        'home_id',
        'floor_id',
        'room_id',
        'is_admin'

    ];

     protected $rules = [
      
	];

	  protected $validationMessages = [
      
        ];

     public $timestamps = true;

    
    function address(){
    	return $this->hasOne(CustomerAddresses::class, 'machine_id', 'id');
    }
}
