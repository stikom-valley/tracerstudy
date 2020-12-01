<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    public function majors()
    {
        return $this->hasMany('App\Major');
    }
}
