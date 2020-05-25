<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB; 

class Roles extends Eloquent {

    protected $table = 'roles';
    // protected $table = 'user_role';

    protected $fillable = array('name');

    public function user(){
      return $this->belongsTo('App\Models\User');
    }
}
