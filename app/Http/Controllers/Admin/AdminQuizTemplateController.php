<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\QuizTemplate;
use App\QuizTemplateSubject;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminQuizTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');

        if (!empty($keyword)) {
            $quizTemplates = QuizTemplate::with('subjects')->where('name', 'LIKE', "%$keyword%")->get();
        } else {
            $quizTemplates = QuizTemplate::with('subjects')->get();
        }
        $quizTemplates->map(function ($elem){
            $elem->questionsCount = 0;
            foreach ($elem->subjects as $subject){
                $elem->questionsCount += $subject->pivot->number_of_questions;
            }
            return $elem;
        });

        return view('admin.quizTemplate.index', compact('quizTemplates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::withCount('questions')->get()->toJson();
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
            'description'=> 'required',
            'subjects'=> 'required'
        ], [
            'subjects.required' => 'Пожалуйста, выберите темы',
            'name.required' => 'Пожалуйста, укажите название',
            'description.required' => 'Пожалуйста, укажите описание',
        ]);

        $template_subjects = json_decode($request->subjects, true);
        $template_subjects = array_map(function ($elem){
            $elem['id'] = (int) $elem['id'];
            $elem['questions_count'] = (int) $elem['questions_count'];
            return $elem;
        }, $template_subjects);

        $quiz_template = new QuizTemplate();
        $quiz_template->name = $request->name;
        $quiz_template->description = $request->description;
        $quiz_template->save();

        foreach ($template_subjects as $subject){
            $quiz_template_subject = new QuizTemplateSubject();
            $quiz_template_subject->quiz_template_id = $quiz_template->id;
            $quiz_template_subject->number_of_questions = $subject['questions_count'];
            $quiz_template_subject->subject_id = $subject['id'];
            $quiz_template_subject->save();
        }

        return redirect()->route('admin.quiz-template.index')->with('flash_message', 'Шаблон теста добавлен!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuizTemplate  $quizTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizTemplate $quizTemplate)
    {
        $quizTemplate = QuizTemplate::with('subjects')->findOrFail($quizTemplate)->toArray();

        $quizTemplate = array_map(function ($elem){
            $elem['id'] = (int) $elem['id'];
            $elem['subjects'] = json_encode(array_map(function ($subject){
                $subject['id'] = (int) $subject['id'];
                $subject['questions_count'] = $subject['pivot']['number_of_questions'];
                unset($subject['pivot']);
                return $subject;
            }, $elem['subjects']));
            return $elem;
        }, $quizTemplate);

        $subjects = Subject::withCount('questions')->get()->toJson();

        return view('admin.quizTemplate.edit', compact('quizTemplate', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required',
            'description'=> 'required',
            'subjects'=> 'required'
        ], [
        'subjects.required' => 'Пожалуйста, выберите темы',
        'name.required' => 'Пожалуйста, укажите название',
        'description.required' => 'Пожалуйста, укажите описание',
        ]
        );

        $template_subjects = json_decode($request->subjects, true);
        $template_subjects = array_map(function ($elem){
            $elem['id'] = (int) $elem['id'];
            $elem['questions_count'] = (int) $elem['questions_count'];
            return $elem;
        }, $template_subjects);

        $quiz_template = QuizTemplate::findOrFail($id);
        $quiz_template->name = $request->name;
        $quiz_template->description = $request->description;
        $quiz_template->save();


        DB::transaction(function () use ($id, $template_subjects, $quiz_template){
            QuizTemplateSubject::where('quiz_template_id', $id)->delete();

            foreach ($template_subjects as $subject){
                $quiz_template_subject = new QuizTemplateSubject();
                $quiz_template_subject->quiz_template_id = $quiz_template->id;
                $quiz_template_subject->number_of_questions = $subject['questions_count'];
                $quiz_template_subject->subject_id = $subject['id'];
                $quiz_template_subject->save();
            }
        });


        return redirect()->route('admin.quiz-template.index')->with('flash_message', 'Шаблон теста обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            QuizTemplateSubject::where('quiz_template_id', $id)->delete();
            QuizTemplate::destroy($id);
        });

        return redirect()->route('admin.quiz-template.index')->with('flash_message', 'Шаблон теста удален!');
    }
}
