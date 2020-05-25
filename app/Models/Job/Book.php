<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;
use Eloquent; // ******** This Line *********
use DB;

class Book extends Model
{
    protected $table = 'book_info';

    protected $fillable = array('book_id', 'title_id', 'title', 'sub_title', 'series_title', 'author', 'publisher', 'category', 'doi', 'isbn', 'e_isbn', 'copy_editing_level');
    
}