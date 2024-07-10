<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginUser extends Model
{
    protected $fillable=[
        'emp_id',
        'role',
        'default_password',
        'updated_password',
        'email'
    ];
}
