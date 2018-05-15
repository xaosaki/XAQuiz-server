<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{

    public function answer()
    {
        return $this->belongsTo('App\Answer');
    }

    public $timestamps = false;
}
