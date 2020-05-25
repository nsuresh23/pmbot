<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;
use Eloquent; // ******** This Line *********
use DB;

class Stage extends Model
{
    protected $table = 'job_stage';

    protected $fillable = array('name', 'status');
    
}