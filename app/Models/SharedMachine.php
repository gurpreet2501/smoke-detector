<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SharedMachine extends Model
{
    protected $table = 'sdetect_shared_machines';

    protected $fillable = ['machine_id','user_id','shared_by'];

		protected $validationMessages = [];

    public $timestamps = true;
    
}
