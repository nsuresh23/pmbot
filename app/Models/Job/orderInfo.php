<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;
use Eloquent; // ******** This Line *********
use DB;

class OrderInfo extends Model
{
    protected $table = 'jobs_orderinfo';

    protected $fillable = array('order_id', 'title_id', 'title', 'sub_title', 'series_title', 'author', 'publisher', 'category', 'doi', 'isbn', 'e_isbn', 'copy_editing_level');
    
}