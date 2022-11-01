<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionDragdrop extends Model
{
    public $table = 'question_dragdrops';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'question_id',
        'left_sentence',
        'right_sentence',
    ];


    public $transcodeColumns = [
        'left_sentence',
        'right_sentence',
    ];
}
