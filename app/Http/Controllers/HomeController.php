<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\QuizTemplate;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizTemplates = QuizTemplate::with('subjects')->paginate(15);
        $quizTemplates->map(function ($elem){
            $elem->questionsCount = 0;
            foreach ($elem->subjects as $subject){
                $elem->questionsCount += $subject->pivot->number_of_questions;
            }
            return $elem;
        });
        return view('home', compact('quizTemplates'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function userQuizzes()
    {
        $quizzes = Quiz::with('template.subjects')->where('user_id', Auth::user()->id)->paginate(15);
        return view('quizzes', compact('quizzes'));
    }
}
