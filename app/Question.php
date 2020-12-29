<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'type_question',
        'type_answer',
        'sequence'
    ];

    public function choices()
    {
        return $this->hasMany('App\Choice');
    }
}
