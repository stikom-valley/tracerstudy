<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'certification_document',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
