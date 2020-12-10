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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['certification_link'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the Certification Document Link
     *
     * @param  string  $value
     * @return string
     */
    public function getCertificationLinkAttribute()
    {
        return url('storage/uploads/certification/' . $this->certification_document);
    }
}
