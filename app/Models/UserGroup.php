<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroup extends Eloquent {
use SoftDeletes;
    protected $table = 'user_group';
    protected $dates = ['deleted_at'];
    protected $fillable = array('user_type_id', 'group_name','reference','affiliation','item_type','grant','validation','math_expression','email','mobile_number','status');

    public function user_type()
    {
        return $this->belongsTo('App\Models\UserType');
    }
    /*public function ticket_volumes()
    {
        return $this->hasMany('App\Models\TicketVolumes');
    }*/

}
?>