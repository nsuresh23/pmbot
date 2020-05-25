<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB; 
class Tickets extends Eloquent {

    protected $table = 'tickets';
    public $timestamps = false;

}
?>