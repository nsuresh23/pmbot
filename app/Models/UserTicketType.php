<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB; 
class UserTicketType extends Eloquent {

    protected $table = 'user_tickettype';
    public $timestamps = false;

    protected $fillable = array('user_id', 'ticket_id');
}
?>