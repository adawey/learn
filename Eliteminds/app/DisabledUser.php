<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DisabledUser extends Model
{
    protected $table = 'disabled_users';
    public $primaryKey = 'id';
    public $timestamps = true;
}
