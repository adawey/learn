<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    protected $table = 'event_user';
    public $primaryKey = 'id';
    public $timestamps = true;

    
}
