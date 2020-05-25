<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;
use Eloquent; // ******** This Line *********
use DB;

class Note extends Model
{
    protected $table = 'task_note';

    protected $with = ['user', 'task'];

    protected $fillable = array('note', 'attachment');

    /**
     * Get the user associated with the note.
     */
    public function user()
    {

        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    /**
     * Get the task associated with the note.
     */
    public function task()
    {

        return $this->hasOne('App\Models\Job\Task', 'id', 'task_id');
    }
    
}