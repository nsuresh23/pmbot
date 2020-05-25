<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Annotation extends Model {

    var $table = 'annotations';

    var $fillable = ['page_id', 'jobid', 'stage', 'userid', 'annotationid', 'text', 'category', 'quote', 'ranges','tasktitle','taskdescription', 'attachment','emailnotation',  'tasknotes', 'createdempcode','additionalattach'];
    
    var $casts = [
        'ranges' => 'json'
    ];
}