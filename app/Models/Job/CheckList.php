<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckList extends Model
{

    protected $table = 'check_list';

    // protected $with = ['job', 'task', 'stage', 'location', 'user'];
    protected $with = ['stage', 'location', 'user'];

    protected $fillable = array('title', 'description', 'category', 'job_id', 'stage_id', 'task_id', 'location_id', 'created_by', 'attachment', 'source');

    /**
     * Get the user associated with the check list.
     */
    public function user()
    {

        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    /**
     * Get the stage associated with the check list.
     */
    public function stage()
    {

        return $this->hasOne('App\Models\Job\Stage', 'id', 'stage_id');
    }

    // public function stage_name()
    // {

    //     return $this->stage->name;

    // }

    /**
     * Get the location associated with the check list.
     */
    public function location()
    {

        return $this->hasOne('App\Models\User\Location', 'id', 'location_id');
    }

    // public function location_name()
    // {

    //     return $this->location->name;
    // }
    
}
