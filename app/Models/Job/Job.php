<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;
use Eloquent; // ******** This Line *********
use DB;

class Job extends Model
{
    protected $table = 'job';

    protected $with = ['user', 'book', 'stage'];

    protected $fillable = array('job_id', 'location', 'status');

    /**
     * Get the user associated with the job.
     */
    public function user()
    {

        return $this->hasOne('App\Models\User', 'id', 'user_id');

    }

    /**
     * Get the book associated with the job.
     */
    public function book()
    {

        return $this->hasOne('App\Models\Job\Book', 'id', 'book_id');

    }

    /**
     * Get the stage associated with the job.
     */
    public function stage()
    {

        return $this->hasOne('App\Models\Job\Stage', 'id', 'stage_id');
        
    }

    /**
     * Get the job count based on job type.
     */
    // public function typeCount()
    // {
    //     $type_info = DB::table($this->table)

    //         ->select('type', DB::raw('count(*) as total'))

    //         ->groupBy('type')

    //         ->get();

    //     return $type_info;
    // }
    
}