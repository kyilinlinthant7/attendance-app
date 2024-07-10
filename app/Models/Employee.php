<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttendanceFilename;


class Employee extends Model
{
    protected $table = 'employees';
    
    protected $guarded = [];
    
    protected $casts = [
        'edu_school' => 'array',
        'edu_duration' => 'array',
        'edu_pass_cont' => 'array',
        'edu_degree' => 'array',
        'edu_remark' => 'array',
        'exp_company' => 'array',
        'exp_duration' => 'array',
        'exp_position' => 'array',
        'exp_salary' => 'array',
        'exp_brief_jd' => 'array',
        'exp_remark' => 'array',
        'train_subject' => 'array',
        'train_duration' => 'array',
        'train_degree' => 'array',
        'train_amount' => 'array',
        'train_p_np' => 'array',
        'train_c_nc' => 'array',
        'train_sd_cdp' => 'array',
        'train_o_cs' => 'array',
        'train_int_ext' => 'array',
        'sts_effective_date' => 'array',
        'sts_reason_of_change' => 'array',
        'sts_from_date' => 'array',
        'sts_to_date' => 'array',
        'sts_other_change' => 'array',
        'sts_remark' => 'array',
        'action_date' => 'array',
        'action_incident_record' => 'array',
        'action_status' => 'array',
        'action_remark' => 'array',
        'loan_date' => 'array',
        'loan_reason' => 'array',
        'loan_amount' => 'array',
        'loan_remark' => 'array',
        'supply_items' => 'array',
        'supply_status' => 'array',
        'supply_date' => 'array',
        'supply_number' => 'array',
        'supply_amount' => 'array',
        'supply_remark' => 'array',
    ];
    
    public function userrole()
    {
        return $this->hasOne('App\Models\UserRole', 'user_id', 'id');
    }

    public function employeeLeaves()
    {
        return $this->hasMany('App\EmployeeLeaves', 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function siteName()
    {
        return $this->belongsTo(Project::class, 'site_name');
    }
    
    public function getSiteName()
    {
        return optional($this->siteName)->name;
    }
    
    public function leave_applies()
    {
        return $this->hasMany(LeaveApply::class);
    }
    
    function getGender($gender) 
    {
        return ($gender == 'Male') ? 'Male' : ($gender == 'Female' ? 'Female' : 'Other');
    }
    
    //worng function
    public function attendance()
    {
        return $this->belongsTo('App\Models\AttendanceFilename')->where(function ($query) {
            $query->whereIn('emp_arr', json_decode($this->id));
        });
    }
}
