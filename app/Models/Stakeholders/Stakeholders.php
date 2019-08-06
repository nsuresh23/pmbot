<?php

namespace PMBot\Models\Stakeholders;

use Illuminate\Database\Eloquent\Model;

class Stakeholders extends Model
{
    public $fillable = ['name', 'email', 'designation', 'phone', 'mobile'];
}
