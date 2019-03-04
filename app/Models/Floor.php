<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $table = 'sdetect_floors';

    protected $fillable = ['name','home_id','user_id'];

	protected $validationMessages = [];

    public $timestamps = true;
    
}
