<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    public $table = 'f_a_qs';
    public $fillable = [
        'title', 'contant'
    ];

    public $transcodeColumns = [
        'title', 'contant'
    ];
}
