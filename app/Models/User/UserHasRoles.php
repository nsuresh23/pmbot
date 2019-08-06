<?php

namespace PMBot;

namespace PMBot\Models\User;

use Eloquent; // ******** This Line *********
use DB;

class UserHasRoles extends Eloquent
{
    protected $table = 'user_has_roles';

    protected $fillable = [
        'role_id', 'user_id'
    ];
    public $timestamps = false;
}
