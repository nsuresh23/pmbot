<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $table = 'task';

    protected $with = ['stage', 'created_user', 'assigned_user'];

    protected $fillable = array('job_id', 'stage_id', 'title', 'description', 'category', 'status', 'created_by', 'assigned_to', 'received_on', 'attachment');

    /**
     * Get the created user associated with the task.
     */
    public function created_user()
    {

        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    /**
     * Get the assigned user associated with the task.
     */
    public function assigned_user()
    {

        return $this->hasOne('App\Models\User', 'id', 'assigned_to');
    }

    /**
     * Get the stage associated with the task.
     */
    public function stage()
    {

        return $this->hasOne('App\Models\Job\Stage', 'id', 'stage_id');
    }

    /**
     * Get the location associated with the task.
     */
    public function location()
    {

        return $this->hasOne('App\Models\User\Location', 'id', 'location_id');
    }

}
