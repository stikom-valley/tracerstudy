<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'gender',
        'phone_number',
        'address',
        'is_married',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function experiences()
    {
        return $this->hasMany('App\Experience');
    }

    public function skills()
    {
        return $this->hasMany('App\Skill');
    }

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }

    public function education()
    {
        return $this->hasOne('App\Education');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    /**
     * Get the Avatar Link
     *
     * @param  string  $value
     * @return string
     */
    public function getAvatarLinkAttribute()
    {
        if ($this->avatar == 'user.png') {
            return asset('/uploads/avatar/' . $this->avatar);
        } else {
            return url('storage/uploads/avatar/' . $this->avatar);
        }
    }

    public function hasRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $value) {
                if ($this->checkUserRole($value)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getUserRole()
    {
        return $this->role()->getResults()->slug;
    }

    public function checkUserRole($role)
    {
        return $role == $this->getUserRole() ? true : false;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
