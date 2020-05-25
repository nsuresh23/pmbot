<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Eloquent; // ******** This Line *********
use DB; 

class Group extends Model
{
    protected $table = 'user_group';

    protected $fillable = array('name', 'status');

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
