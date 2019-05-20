<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MotionDetectors extends Model
{
    protected $table = 'sdetect_motion_detectors';

    protected $fillable = ['machine_id','serial','name','motion_detector_status','motion_detector_button_status' ,'user_id'];

	  protected $validationMessages = [];

    public $timestamps = true;
    
}
