<?php

namespace App\Models;

use App\Shift;
use Illuminate\Database\Eloquent\Model;

class LeaveApply extends Model
{
    protected $table = 'leave_applies';
    protected $fillable=[
        'leader',
        'site_id',
        'site_name',
        'shift_id',
        'emp_id',
        'name',
        'leave_type',
        'dateFrom',
        'dateTo',
        'total',
        'date_claim',
        'content',
        'cc_remark',
        'hr_remark',
        'other',
        'photo',
        'manager_status',
        'hr_status',
        'status',
        'delete_status'
    ];
    
    protected $casts = [
        'total' => 'decimal:1',
    ];
    
    
    public function leavetypeapply()
    {
        return $this->hasOne('App\Models\LeaveTypeApply', 'leave_apply_id', 'id');
    }
    
    public function employees()
    {
        return $this->belongsTo(Employee::class,'emp_id');
    }

    public function shift() 
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
