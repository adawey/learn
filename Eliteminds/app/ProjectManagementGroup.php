<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectManagementGroup extends Model
{
    protected $table = 'project_management_groups';
    public $primaryKey = 'id';
    public $timestamps = true;
}
