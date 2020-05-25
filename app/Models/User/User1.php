<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Eloquent; // ******** This Line *********
use DB;

class User extends Model
{
    protected $table = 'users';

    protected $with = ['role', 'group'];

    protected $fillable = array('name', 'email', 'password', 'role_id', 'group_id', 'status');

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the role associated with the user.
     */
    public function role()
    {

        return $this->hasOne('App\Models\User\Role', 'id', 'role_id');

    }

    /**
     * Get the group associated with the user.
     */
    public function group()
    {

        return $this->hasOne('App\Models\User\Group', 'id', 'group_id');

    }

    public function isAdmin()
    {

        return $this->role()->where('name', 'admin')->exists();

    }

    public function isAM()
    {

        return $this->role()->where('name', 'am')->exists();

    }

    public function isPM()
    {

        return $this->role()->where('name', 'pm')->exists();

    }

    public function isStakeholder()
    {

        return $this->role()->where('name', 'stakeholder')->exists();

    }
    
}
