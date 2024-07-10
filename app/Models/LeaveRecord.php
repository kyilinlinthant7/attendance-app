<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRecord extends Model
{
    protected $table='leave_record';
    protected $fillable=[
        'employee_id',
        'casual_leave',
        'earned_leave',
        'medical_leave',
        'maternity_leave',
        'paternity_leave',
        'compassionate_leave',
        'without_pay_leave',
        'absent_leave',
        'remark'
    ];
}
