<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB; 
class TicketInfo extends Eloquent {

    protected $table = 'ticketinfo';
    public $timestamps = false;	

}
?>