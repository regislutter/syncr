<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Copydeck extends Model
{
    public function project(){
        return $this->belongsTo('App\Project');
    }
    public function files(){
        return $this->hasMany('App\File');
    }
}
