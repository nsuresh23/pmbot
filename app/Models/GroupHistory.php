<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB;

class GroupHistory extends Eloquent {

    protected $table = 'group_history';
    public $timestamps = false;
    protected $fillable = array('logged_user', 'user_ip','group_id','key','value','action','created_at');
    

}
?>