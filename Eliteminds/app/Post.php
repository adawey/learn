<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    public $table = 'posts';

    public $fillable = [
        'title',
        'prepared_by',
        'published_by',
        'linkedin',
        'content',
        'vimeo_id',
    ];

    public $transcodeColumns = [
        'title',
        'prepared_by',
        'published_by',
        'content',
    ];
}
