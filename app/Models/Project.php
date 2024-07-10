<?php

namespace App\Models;

use App\Shift;
use Illuminate\Database\Eloquent\Model;

    class Project extends Model
    {
        protected $table = 'projects';
        protected $guarded = [];

        protected $fillable =[
            'name',
            'description',
            'code',
            'client_id',
            'short_term',
            'shifts',
            'delete_status'
        ];

        public function client()
        {
            return $this->belongsTo(Client::class);
        }

        public function shifts() 
        {
            return $this->hasMany(Shift::class, 'site_id', 'id');
        }
    }
