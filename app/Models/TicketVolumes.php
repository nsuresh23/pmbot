<?php
namespace App\Models;
use Eloquent; // ******** This Line *********
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketVolumes extends Eloquent {
use SoftDeletes;
    protected $table = 'ticket_volumes';

  public function volume_dates()
    {
    	 //return $this->hasMany('App\Models\State', 'country_id' , 'id');
        return $this->hasMany('App\Models\VolumeDates','volume_id','id');
    }

}
?>