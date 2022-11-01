<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public $table = 'exams';
    protected $fillable = [
        'name', 'duration',
    ];

    public $transcodeColumns = [
        'name',
    ];
}
