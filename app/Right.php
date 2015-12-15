<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Right extends Model {
    const CLIENT_CREATE = 1;
    const CLIENT_MODIFY = 2;
    const CLIENT_DELETE = 3;
    const CLIENT_ARCHIVE = 8;
    const PROJECT_CREATE = 4;
    const PROJECT_MODIFY = 5;
    const PROJECT_DELETE = 6;
    const PROJECT_SUBSCRIBE = 7;
    const PROJECT_ARCHIVE = 9;
    const COPYDECK_CREATE = 10;
    const COPYDECK_MODIFY = 11;
    const COPYDECK_DELETE = 12;
    const VERSION_CREATE = 13;
    const VERSION_MODIFY = 14;
    const VERSION_DELETE = 15;
    const VERSION_STATUS_TO_IN_EDITION = 16;
    const VERSION_STATUS_TO_READY = 17;
    const VERSION_STATUS_TO_IN_DEVELOPMENT = 18;
    const VERSION_STATUS_TO_DEPLOYED = 19;
    const USER_CREATE = 20;
    const USER_MODIFY = 21;
    const USER_DELETE = 22;
    const USER_CHANGE_ROLES = 23;
    const ROLE_CREATE = 24;
    const ROLE_MODIFY = 25;
    const ROLE_DELETE = 26;
    const RIGHT_CREATE = 27;
    const RIGHT_MODIFY = 28;
    const RIGHT_DELETE = 29;
    const ACCESS_ADMIN = 30;
    const CREATE_DISCUSSION = 31;
    const DELETE_DISCUSSION = 32;
    const POST_MESSAGE = 33;
    const EDIT_MESSAGE = 34;
    const DELETE_MESSAGE = 35;

    public function roles(){
        return $this->belongsToMany('App\Role', 'roles_rights');
    }
}