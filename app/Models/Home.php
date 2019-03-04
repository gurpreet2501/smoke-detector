<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $table = 'sdetect_homes';

    protected $fillable = ['name','address','city','state','country','zip','latitude','longitude','user_id'];

	protected $validationMessages = [];

    public $timestamps = true;
    
}
