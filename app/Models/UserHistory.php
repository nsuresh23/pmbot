<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB;

class UserHistory extends Eloquent {

    protected $table = 'user_history';
    public $timestamps = false;
    protected $fillable = array('logged_user', 'user_ip','user_id','key','value','action','created_at');
    

}
?>