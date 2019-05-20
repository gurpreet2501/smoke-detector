<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MotionDetectors extends Model
{
    protected $table = 'sdetect_motion_detectors';

    protected $fillable = ['machine_id','serial','name','status','user_id'];

	  protected $validationMessages = [];

    public $timestamps = true;
    
}
