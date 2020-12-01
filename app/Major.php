<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'faculty_id',
        'name',
        'slug'
    ];

    public function faculty()
    {
        return $this->belongsTo('App\Faculty', 'faculty_id');
    }
}
