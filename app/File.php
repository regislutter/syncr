<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    const STATUS_IN_EDITION = 0;
    const STATUS_READY = 1;
    const STATUS_IN_DEVELOPMENT = 2;
    const STATUS_DEPLOYED = 3;

    protected $dates = ['created_at', 'updated_at', 'status_updated_at'];

    public function copydeck(){
        return $this->belongsTo('App\Copydeck');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * Get the status' text for the Copydeck Version
     *
     * @return string
     */
    public function getStatusText(){
        switch($this->status){
            case self::STATUS_IN_EDITION:
                return 'In edition';
                break;
            case self::STATUS_READY:
                return 'Ready for development';
                break;
            case self::STATUS_IN_DEVELOPMENT:
                return 'In development';
                break;
            case self::STATUS_DEPLOYED:
                return 'Deployed';
                break;
            default:
                return 'Unknown';
                break;
        }
        return 'Unknown';
    }
}
