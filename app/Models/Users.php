<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{

    protected $table = 'tank_auth_users';

    protected $fillable = ['username','password','email','activated','banned','device_id','phone','role','name','password_reset_token','device_type','device_token'];

     protected $rules = [
        'username' => 'required|unique',
        'password' => 'required',
        'email' => 'required|unique',
        'name' => 'required',
	  ];

	  protected $validationMessages = [
        'name.required' => 151,
        'password.required' => 125,
        'email.required' => 126,
        'username.required' => 124,
        'username.unique' => 127,
        'email.unique' => 128,
    	'email.required_without' => 129,
        ];

     public $timestamps = true;

     function address(){
        return $this->hasOne('App\Models\CustomerAddresses', 'user_id', 'id');
     }
    
}
