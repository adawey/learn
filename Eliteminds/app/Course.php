<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $table = 'courses';
    protected $fillable = [
        'title', 'slug', 'private'
    ];

    public $transcodeColumns = [
        'title',
    ];
}
