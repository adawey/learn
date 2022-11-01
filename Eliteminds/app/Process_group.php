<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process_group extends Model
{
    public $table = 'process_groups';
    public $primaryKey = 'id';
    public $timestamps = true;

    public $fillable = [
        'name',
    ];

    public $transcodeColumns = [
        'name',
    ];
}
