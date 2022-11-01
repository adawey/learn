<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserScore extends Model
{
    protected $table = 'user_scores';
    public $primaryKey = 'id';
    public $timestamps = true;
}
