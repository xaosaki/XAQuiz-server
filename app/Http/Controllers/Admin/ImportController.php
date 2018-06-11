<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Question;
use App\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    //
    public function import()
    {
        $message = '';
        return view('admin.import.index', compact('message'));
    }
    public function postImport(Request $request)
    {
        $path = $request->questions->store('question-imports');
        $collection = Excel::load('storage/'.$path, function($reader) {
            $reader->noHeading();
        })->toArray();

        $questions = [];

        array_reduce($collection, function($carry, $item) use (&$questions){
            if(is_null($carry)){
                $iterators = [
                    'question' => 0,
                    'answer' => 0
                ];
                if(!isset($item[2])){
                    throw new Exception('Неверное форматирование файла');
                }
            } else {
                $iterators = $carry;
            }
            if(isset($item[2])){
                $questions[$iterators['question']]['text'] = $item[0];
                $questions[$iterators['question']]['category'] = $item[1];
                $questions[$iterators['question']]['complexity_level'] = $item[2];

            } elseif(is_null($item[0])) {
                $iterators['question']++;
                $iterators['answer'] = 0;
            } else {
                $questions[$iterators['question']]['answers'][$iterators['answer']]['text']  = $item[0];
                $questions[$iterators['question']]['answers'][$iterators['answer']]['is_correct']  = is_null($item[1]) ? false : true;
                $iterators['answer']++;
            }
            return $iterators;
        });

        $errors = [];
        foreach ($questions as $question){
            $res = $this->storeQuestion($question);
            if(!is_null($res)){
                array_push($errors, $res);
            }
        }
        $message = '';
        if(count($errors) === 0){
            $message .=  "Импорт прошел успешно";
            $message .= "<br>";
        } else {
            $message .=  "Импорт прошел с ошибками:";
            $message .= "<br>";
            foreach ($errors as $error){
                $message .= $error;
                $message .= "<br>";
            }
        }
        return view('admin.import.index', compact('message'));
    }

    public function storeQuestion($question){
        $answers = $question['answers'];
        $parsed_question = $question;
        $correctCount = 0;
        $subject = Subject::where('name', $question['category'])->first();
        if(is_null($subject)){
            return 'Тема "'.$question['category'].'" не найдена, вопрос не импортирован.';
        }
        foreach ($answers as $item){
            if($item['is_correct']){
                $correctCount++;
            }
        }

        DB::transaction(function () use ($parsed_question, $subject, $answers, $correctCount){
            $question = new Question();
            $question->text = $parsed_question['text'];
            if($correctCount > 1){
                $question->type = 'checkbox';
            } else {
                $question->type = 'radio';
            }
            $question->subject_id = $subject->id;
            $question->correct_answers = $correctCount;
            $question->complexity_level = intval($parsed_question['complexity_level']);
            $question->save();

            foreach ($answers as $answer){
                $answer_model = new Answer();
                $answer_model->text = $answer['text'];
                $answer_model->is_correct = $answer['is_correct'];
                $answer_model->question_id = $question->id;
                $answer_model->save();
            }
        });

         return null;
    }
}
