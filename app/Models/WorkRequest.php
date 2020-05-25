<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB;

class WorkRequest extends Eloquent {
    protected $table = 'workrequest';
 

    public function ticket_type()
    {
        return $this->belongsTo('App\Models\TicketType');
    }
   

}
?>