<?php

namespace App;

use App\QuestionRoles;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    public $table = 'packages';
    public $primaryKey = 'id';
    public $timestamps = true;

    public $fillable = [
        'name',
        'description',
        'what_you_learn',
        'requirement',
        'who_course_for'
    ];

    public $transcodeColumns = [
        'name',
        'description',
        'what_you_learn',
        'requirement',
        'who_course_for'
    ];
}
