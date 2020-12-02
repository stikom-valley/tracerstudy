<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'faculty_id',
        'major_id',
        'entry_year',
        'graduation_year',
        'score',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function faculty()
    {
        return $this->belongsTo('App\Faculty', 'faculty_id');
    }

    public function major()
    {
        return $this->belongsTo('App\Major', 'major_id');
    }
}
