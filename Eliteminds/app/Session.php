<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;


class Session extends Authenticatable
{
    
    protected $table = 'sessions';
    public $primaryKey = 'id';
    public $timestamps = true;
    
    

    
}
