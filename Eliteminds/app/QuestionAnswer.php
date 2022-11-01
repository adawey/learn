<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    public $table = 'question_answers';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'question_id',
        'is_correct',
        'answer',
    ];


    public $transcodeColumns = [
        'answer'
    ];
}
