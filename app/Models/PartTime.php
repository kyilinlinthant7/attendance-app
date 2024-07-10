<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartTime extends Model
{
    protected $fillable = [
        'name',
        'nrc',
        'dob',
        'photo',
        'phone',
        'address'
    ];
}
