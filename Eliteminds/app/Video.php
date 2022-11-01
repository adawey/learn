<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public $table = 'videos';
    protected $fillable = [
        'title', 'description'
    ];

    public $transcodeColumns = [
        'title', 'description'
    ];
}
