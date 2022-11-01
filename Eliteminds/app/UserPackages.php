<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPackages extends Model
{
    
    protected $table = 'user_packages';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function packages(){
        return $this->belongsTo('App\Packages', 'package_id', 'id');
    }
}
