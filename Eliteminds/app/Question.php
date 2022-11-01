<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $table = 'questions';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $casts = [
        'exam_num' => 'array',
    ];

    protected $fillable = [
        'title',
        'a',
        'b',
        'c',
        'correct_answer',
        'feedback',
        'chapter',
        'project_management_group',
        'process_group',
        'exam_num',
        'img',
        'demo',
    ];


    public $transcodeColumns = [
        'title',
        'feedback',
    ];
}
