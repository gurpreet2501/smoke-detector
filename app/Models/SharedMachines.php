<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SharedMachines extends Model
{

    protected $table = 'sdetect_shared_machines';
  

    protected $fillable = ['machine_id','shared_with','shared_by'];

     public $timestamps = true;

    
}
