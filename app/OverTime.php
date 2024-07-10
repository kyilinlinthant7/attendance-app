<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverTime extends Model
{
    protected $fillable = [
        'leader',
        'site_id',
        'site_name',
        'shift_id',
        'shift_name',
        'emp_arr',
        'otdate',
        'ot_type',
        'fromtime',
        'totime',
        'content',
        'remark',
        'completion_report',
        'status',
        'delete_status'
    ];

    public function shift() {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
