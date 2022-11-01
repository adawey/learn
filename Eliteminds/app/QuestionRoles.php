<?php

namespace App;

use App\Packages;
use Illuminate\Database\Eloquent\Model;

class QuestionRoles extends Model
{
    protected $table = 'question_roles';
    public $primaryKey = 'id';
    public $timestamps = true;

}
