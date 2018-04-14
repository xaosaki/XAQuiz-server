<?php

namespace App\Http\Controllers;

use App\QuizTemplate;
use Illuminate\Http\Request;

class QuizTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizTemplates = QuizTemplate::with('subjects.questions.answers')->get();

        return $quizTemplates;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
