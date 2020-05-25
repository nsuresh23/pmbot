<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Eloquent; // ******** This Line *********
use DB;

class Role extends Model
{
    protected $table = 'user_role';

    protected $fillable = array('name', 'status');

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
