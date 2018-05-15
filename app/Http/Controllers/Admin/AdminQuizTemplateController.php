<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\QuizTemplate;
use App\QuizTemplateSubject;
use App\Subject;
use Illuminate\Http\Request;

class AdminQuizTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizTemplates = QuizTemplate::with('subjects')->get();
        $quizTemplates->map(function ($elem){
            $elem->questionsCount = 0;
            foreach ($elem->subjects as $subject){
                $elem->questionsCount += $subject->pivot->number_of_questions;
            }
            return $elem;
        });

        return view('admin.quizTemplate.list', ['quizTemplates' => $quizTemplates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('admin.quizTemplate.create', ['subjects' => $subjects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
            'subjects'=> 'required'
        ]);

        $template_subjects = json_decode($request->subjects, true);
        $template_subjects = array_map(function ($elem){
            $elem['id'] = (int) $elem['id'];
            $elem['questionsCount'] = (int) $elem['questionsCount'];
            return $elem;
        }, $template_subjects);

        $quiz_template = new QuizTemplate();
        $quiz_template->name = $request->name;
        $quiz_template->save();

        foreach ($template_subjects as $subject){
            $quiz_template_subject = new QuizTemplateSubject();
            $quiz_template_subject->quiz_template_id = $quiz_template->id;
            $quiz_template_subject->number_of_questions = $subject['id'];
            $quiz_template_subject->subject_id = $subject['questionsCount'];
            $quiz_template_subject->save();
        }

        return redirect()->route('admin.quiz-template.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QuizTemplate  $quizTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(QuizTemplate $quizTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuizTemplate  $quizTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizTemplate $quizTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuizTemplate  $quizTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizTemplate $quizTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuizTemplate  $quizTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizTemplate $quizTemplate)
    {
        //
    }
}
