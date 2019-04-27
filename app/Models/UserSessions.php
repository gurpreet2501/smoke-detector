<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserSessions extends Model
{
    protected $table = 'user_sessions';
    protected $fillable = ['user_id','token'];
      protected $rules = [
        'user_id' => 'required',
        'token' => 'required|unique',
	  ];
     protected $validationMessages = [
        'token.unique' => 137,
        ];
    public $timestamps = true;

}
