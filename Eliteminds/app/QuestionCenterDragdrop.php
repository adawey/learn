<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionCenterDragdrop extends Model
{
    public $table = 'question_center_dragdrops';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'question_id',
        'correct_sentence',
        'center_sentence',
        'wrong_sentence',
    ];


    public $transcodeColumns = [
        'correct_sentence',
        'center_sentence',
        'wrong_sentence',
    ];
}
