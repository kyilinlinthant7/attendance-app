<?php

namespace App\Models;

use App\Shift;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class AttendanceFilename extends Model
{
    protected $fillable = [
        'leader',
        'emp_arr',
        'rv_arr',
        'part_time',
        'dayoff',
        'status',
        'name',
        'site',
        'shift_id',
        'date',
        'time',
        'lat',
        'long',
        'delete_status'
    ];
    
    public static function savefileName($filename, $description, $date)
    {
        $instance = new AttendanceFilename();
        $instance->name = $filename;
        $instance->description = $description;
        $instance->date = date_format(date_create($date), 'Y-m-d');
        $instance->save();
    }

    public function shift() 
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
    
    public function employees()
    {
        return $this->belongsToMany(Employee::class, null, 'emp_arr');
    }
    
    public function leaders()
    {
        return $this->belongsTo(Employee::class,'leader');
    }
    
    public function projects()
    {
        return $this->belongsTo(Project::class,'site');
    }
}
