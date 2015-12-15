<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function discussion(){
        return $this->belongsTo('App\Discussion');
    }

    public function author(){
        return $this->belongsTo('App\User');
    }

    public function messages(){
        return $this->hasMany('App\Message');
    }
}
