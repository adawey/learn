<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';
    public $primaryKey = 'id';
    public $timestamps = true;
    
}
