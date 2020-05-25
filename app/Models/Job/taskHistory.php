<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;
use Eloquent; // ******** This Line *********
use DB;

class TaskHistory extends Model
{
    protected $table = 'task_history';

    protected $with = ['job', 'task', 'user'];

    protected $fillable = array('job_id', 'task_id', 'user_id', 'field_name', 'original_value', 'modified_value');

    /**
     * Get the job associated with the task history.
     */
    public function job()
    {

        return $this->hasOne('App\Models\Job\Job', 'id', 'job_id');
    }

    /**
     * Get the task associated with the task history.
     */
    public function task()
    {

        return $this->hasOne('App\Models\Job\Task', 'id', 'task_id');
    }

    /**
     * Get the user associated with the task history.
     */
    public function user()
    {

        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}