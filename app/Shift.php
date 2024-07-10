<?php

namespace App;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'shifts';
    protected $guarded = [];

    protected $fillable = [
        'name',
        'full_name',
        'site_id',
        'start_time',
        'end_time'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
