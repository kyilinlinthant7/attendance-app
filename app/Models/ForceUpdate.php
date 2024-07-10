<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForceUpdate extends Model
{
    protected $table = 'force_updates';
    protected $fillable = [
        'version',
        'flag'
    ];
}
