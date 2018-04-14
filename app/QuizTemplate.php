<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizTemplate extends Model
{
    //

    public function subjects()
    {
        return $this->belongsToMany('App\Subject', 'quiz_template_subject', 'quiz_template_id', 'subject_id')->withPivot('number_of_questions');
    }
}
