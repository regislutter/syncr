<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const WATCHER = 1;
    const EDITOR = 2;
    const DEVELOPER = 3;
    const ADMIN = 4;
    const SUPER_ADMIN = 5;

    public function users(){
        return $this->belongsToMany('App\User', 'users_roles');
    }
    public function rights(){
        return $this->belongsToMany('App\Right', 'roles_rights');
    }

    /**
     * Check if the role has the right to do something
     *
     * @param $rightId
     * @return bool
     */
    public function hasRight($rightId)
    {
        foreach ($this->rights()->get() as $right)
        {
            if ($right->id == $rightId)
            {
                return true;
            }
        }

        return false;
    }
}
