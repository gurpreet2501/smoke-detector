<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CustomerAddresses extends Model
{


    protected $table = 'customer_addresses';

    protected $fillable = ['address','city','state','zip','latitude','longitude','user_id','machine_id'];

    protected $rules = [
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zip' => 'required',
     
	  ];

	  protected $validationMessages = [
   
        ];

     public $timestamps = true;

}
