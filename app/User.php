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
        return $this->hasOne('App\Role');
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
        return asset('public/uploads/' . $this->avatar);
    }
}
