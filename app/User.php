<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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
        'reg_number',
        'email',
        'password',
        'gender',
        'phone_number',
        'address',
        'birth_date',
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
        'birth_date' => 'datetime',
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
}
