<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function subjects()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer', 'question_id');
    }
    public $timestamps = false;
}
