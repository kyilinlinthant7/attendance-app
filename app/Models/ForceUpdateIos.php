<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForceUpdateIos extends Model
{
    protected $table = 'force_update_ios';
    protected $fillable = [
        'version',
        'flag'
    ];
}
