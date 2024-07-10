<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SBU extends Model
{
    protected $table = 'sbu_names';
    protected $fillable = [
        'name'
    ];
}
