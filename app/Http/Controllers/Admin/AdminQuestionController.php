<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Question;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class AdminQuestionController extends Controller
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
            $questions = Question::with('subjects')->where('text', 'LIKE', "%$keyword%")->get();
        } else {
            $questions = Question::with('subjects')->get();
        }
        return view('admin.question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::pluck('name','id');
        return view('admin.question.create', ['subjects' => $subjects]);
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
            'text'=> 'required',
            'subject_id'=> 'required',
            'complexity_level'=> 'required',
            'answers' => 'required'
        ], [
            'subject_id.required' => 'Пожалуйста, выберите тему',
            'text.required' => 'Пожалуйста, укажите название',
            'answers.required' => 'Пожалуйста, укажите ответы',
            'complexity_level.required' => 'Пожалуйста, укажите сложность',
        ]);

        $request_answers = json_decode($request->answers);


        $correctCount = 0;
        foreach ($request_answers as $item){
            if($item->is_correct){
                $correctCount++;
            }
        }

        DB::transaction(function () use ($request, $request_answers, $correctCount){
            $question = new Question();
            $question->text = $request->text;
            if($correctCount > 1){
                $question->type = 'checkbox';
            } else {
                $question->type = 'radio';
            }
            $question->subject_id = $request->subject_id;
            $question->correct_answers = $correctCount;
            $question->complexity_level = $request->complexity_level;
            $question->save();

            foreach ($request_answers as $answer){
                $answer_model = new Answer();
                $answer_model->text = $answer->text;
                $answer_model->is_correct = $answer->is_correct;
                $answer_model->question_id = $question->id;
                $answer_model->save();
            }
        });


        return redirect()->route('admin.question.index')->with('flash_message', 'Новый вопрос добавлен!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subjects = Subject::pluck('name','id');
        $question = Question::with('answers')->findOrFail($id);
        $question->answers = $question->answers->toJson();

        return view('admin.question.edit', compact('question', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'text'=> 'required',
            'subject_id'=> 'required',
            'answers' => 'required',
            'complexity_level' => 'required'
        ], [
            'subject_id.required' => 'Пожалуйста, выберите тему',
            'text.required' => 'Пожалуйста, укажите название',
            'answers.required' => 'Пожалуйста, укажите ответы',
            'complexity_level.required' => 'Пожалуйста, укажите сложность',
        ]);

        $request_answers = json_decode($request->answers);


        $correctCount = 0;
        foreach ($request_answers as $item){
            if($item->is_correct){
                $correctCount++;
            }
        }

        DB::transaction(function () use ($id, $request, $request_answers, $correctCount){
            $question = Question::with('answers')->findOrFail($id);
            $question->text = $request->text;
            if($correctCount > 1){
                $question->type = 'checkbox';
            } else {
                $question->type = 'radio';
            }
            $question->subject_id = $request->subject_id;
            $question->correct_answers = $correctCount;
            $question->complexity_level = $request->complexity_level;
            $question->save();

            $question_old_answers = $question->answers;

            foreach ($request_answers as $answer){
                if($answer->id !== null){
                    if($answer->question_id !== $question->id){
                        $answer->question_id = $question->id;
                    }
                    if($question_old_answers->contains('id', $answer->id)){
                        $answer_model = Answer::findOrFail($answer->id);
                        $answer_model->text = $answer->text;
                        $answer_model->is_correct = $answer->is_correct;
                        $answer_model->save();
                        $question_old_answers = $question_old_answers->reject(function($element) use ($answer){
                            return $element->id == $answer->id;
                        });
                    }
                } else {
                    $answer_model = new Answer();
                    $answer_model->text = $answer->text;
                    $answer_model->is_correct = $answer->is_correct;
                    $answer_model->question_id = $question->id;
                    $answer_model->save();
                }
            }
            foreach ($question_old_answers as $answer){
                Answer::where('id', $answer->id)->delete();
            }
        });


        return redirect()->route('admin.question.index')->with('flash_message', 'Вопрос изменен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            Answer::where('question_id', $id)->delete();
            Question::destroy($id);
        });

        return redirect()->route('admin.question.index')->with('flash_message', 'Вопрос удален!');
    }
}
