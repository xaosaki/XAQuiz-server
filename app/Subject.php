<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function questions()
    {
        return $this->hasMany('App\Question', 'subject_id');
    }

    public $timestamps = false;
}
