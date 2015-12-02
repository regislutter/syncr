<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    public function roles(){
        return $this->belongsToMany('App\Role', 'users_roles');
    }
    public function subscriptions(){
        return $this->hasMany('App\Subscription');
    }
    public function files(){
        return $this->hasMany('App\File');
    }
    public function copydecks(){
        return $this->hasManyThrough('App\Copydeck', 'App\File');
    }

    public function subscribedFiles($status){
        $files = null;
        $subs = $this->subscriptions()->get();
        foreach($subs as $sub){
            $project = $sub->project()->get();
            foreach($project as $proj){
                $copydecks = $proj->copydecks()->get();
                foreach($copydecks as $cd){
                    if($status !== 'all'){
                        if($files == null){
                            $files = $cd->files()->where('status', $status)->get();
                        }else{
                            $files = $files->merge($cd->files()->where('status', $status)->get());
                        }
                    }else{
                        if($files == null){
                            $files = $cd->files()->get();
                        }else{
                            $files = $files->merge($cd->files()->get());
                        }
                    }
                }

            }
        }

        if($files == null){
            return $files;
        }
        return $files->sortByDesc('created_at');
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'avatar', 'hobbies', 'phone', 'phonepost'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Check if the user has the role
     *
     * @param $roleId
     * @return bool
     */
    public function is($roleId)
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->id == $roleId)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has not the role
     *
     * @param $roleId
     * @return bool
     */
    public function isNot($roleId)
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->id == $roleId)
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the user is subscribed to a project
     *
     * @param $projectId
     * @return bool
     */
    public function isSubscribed($projectId){
        foreach ($this->subscriptions()->get() as $sub){
            if($sub->project_id == $projectId){
                return true;
            }
        }

        return false;
    }
}
