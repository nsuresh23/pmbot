<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB;

class VolumeDates extends Eloquent {

    protected $table = 'volume_dates';

    protected $fillable = array('volume_id', 'from_date','to_date');
    /*public function ticket_volumes()
    {
    	return $this->hasMany('App\Models\TicketVolumes','id','volume_id');
        //return $this->belongsTo('App\Models\TicketVolumes');
    }*/

}
?>