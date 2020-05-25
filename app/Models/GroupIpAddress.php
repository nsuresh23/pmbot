<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB; 
class GroupIpAddress extends Eloquent {

    protected $table = 'group_ipaddress';
    public $timestamps = false;

    protected $fillable = array('group_id', 'ip_address');
}
?>