<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'sdetect_rooms';

    protected $fillable = ['name','home_id','floor_id','user_id'];

	protected $validationMessages = [];

    public $timestamps = true;
    
}
