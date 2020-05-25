<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB; 

class UserType extends Eloquent {

    protected $table = 'user_types';

    public function user_group()
    {
        return $this->hasMany('App\Models\UserGroup');
    }
}
?>