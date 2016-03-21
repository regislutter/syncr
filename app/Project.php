<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function client(){
        return $this->belongsTo('App\Client');
    }

    public function designchart(){
        return $this->belongsTo('App\DesignChart');
    }

    public function copydecks(){
        return $this->hasMany('App\Copydeck');
    }

    public function tickets(){
        return $this->hasMany('App\Ticket');
    }

    public function discussions(){
        return $this->hasMany('App\Discussion');
    }

    public function subscriptions(){
        return $this->hasMany('App\Subscription');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'client_id'];
}
