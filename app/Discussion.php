<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function copydeck(){
        return $this->belongsTo('App\Copydeck');
    }

    public function author(){
        return $this->belongsTo('App\User');
    }

    public function messages(){
        return $this->hasMany('App\Message');
    }

    public function direct_messages(){
        return $this->hasMany('App\Message')->whereNotNull('message_id');
    }
}
