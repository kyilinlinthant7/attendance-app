<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convarsation extends Model
{
    protected $fillable = array('message','user_id','team_id');
}
