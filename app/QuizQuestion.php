<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function quizAnswers()
    {
        return $this->hasMany('App\QuizAnswer');
    }

    public $timestamps = false;
}
