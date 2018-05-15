<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    //
    public function template()
    {
        return $this->belongsTo('App\QuizTemplate', 'quiz_template_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')->select(array('id', 'name'));
    }

    public $timestamps = false;
}
