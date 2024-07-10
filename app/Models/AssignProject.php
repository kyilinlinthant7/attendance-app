<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class AssignProject extends Model
{
    protected $fillable =[
        'user_id',
        'project_id',
        'shift_id',
        'shift_name',
        'leader_id',
        'emp_arr',
        'rv_arr',
        'part_time',
        'shift',
        'authority_id',
        'date_of_assignment',
        'date_of_release',
        'delete_status'
    ];
    
    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function authority()
    {
        return $this->hasOne(User::class, 'id', 'authority_id');
    }

    public function project()
    {
        return $this->hasOne('\App\Models\Project', 'id', 'project_id');
    }
}