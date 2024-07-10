<?php

namespace App;
use App\Models\Employee;
use App\Models\Project;
use App\Models\UserRole;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
     protected $table = 'login_users';
    protected $fillable = [
        // 'name', 'email', 'password',
        
        'emp_id',
        'role',
        'default_password',
        'updated_password',
        'remember_token',
        'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'password', 'remember_token',
        
        'default_password',
        'updated_password',
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }
    
    public function employeeData()
    {
        return $this->hasOne(Employee::class, 'id', 'emp_id');
    }

    public function isAdmin()
    {
        $role = Auth::user()->role;

        if ($role == "Admin") {
            return true;
        } else {
            return false;
        }
    }

    public function isCpManager()
    {
        $cpmanager = Auth::user()->role;

        if ($cpmanager == "Clean Pro Manager") {
            return true;
        } else {
            return false;
        }
    }

    public function isCpAdministrator()
    {
        $administrator = Auth::user()->role;

        if ($administrator == "Clean Pro Administrator") {
            return true;
        } else {
            return false;
        }
    }

    public function isCpAdmin()
    {
        $cpadmin = Auth::user()->role;

        if ($cpadmin == "Clean Pro Admin") {
            return true;
        } else {
            return false;
        }
    }


    public function isLeader() 
    {
        $leader = Auth::user()->role;

        if ($leader == "leader") {
            return true;
        } else {
            return false;
        }
    }

    public function isHR()
    {
        $hr = Auth::user()->role;
        
        if($hr == "HR Manager") {
            return true;
        } else {
            return false;
        }
    }
    
    
    public function isAssistantHrManager(){
        $assistantHr = Auth::user()->role;

        if($assistantHr == "Assistant HR Manager"){
            return true;
        }else{
            return false;
        }
    }

    public function isHrOfficerRecruit(){
        $aa = Auth::user()->role;
        
        if($aa == "HR Officer (Recruit & Select)"){
            return true;
        }else{
            return false;
        }
    }

    public function isHrOfficerCompen()
    {
        $bb = Auth::user()->role;

        if ($bb == "HR Officer (Compen & Benefit)") {
            return true;
        } else {
            return false;
        }
    }

    public function isHrER()
    {
        $cc = Auth::user()->role;

        if ($cc == "HR Officer (ER & Dev)") {
            return true;
        } else {
            return false;
        }
    }

    public function isHrAssistant() 
    {
        $dd = Auth::user()->role;

        if ($dd == "HR Assistant") {
            return true;
        } else {
            return false;
        }
    }
}
