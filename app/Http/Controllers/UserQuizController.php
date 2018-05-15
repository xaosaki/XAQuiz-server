<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Quiz;
use App\QuizAnswer;
use App\QuizQuestion;
use App\QuizTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserQuizController extends Controller
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
     * Отрисовывает форму создания теста
     *
     * @param $templateId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($templateId)
    {
        $template = QuizTemplate::with('subjects.questions')->findOrFail($templateId);
        // Создаем новый тест
        $quiz = $this->createNewQuiz($template);
        $quiz->questions_count = 0;

        // Наполняем тест вопросами по темам
        foreach ($template['subjects'] as $subject ){
            // Попутно считаем общее количество вопросов
            $quiz->questions_count += $this->addSubjectToQuiz($subject, $quiz->id);
        }

        $quiz->save();


        return view('quiz.create', ['quiz_id' => $quiz->id]);
    }

    /**
     * Отрисовывает вопрос
     *
     * @param $quizId
     * @param $questionNumber
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function question($quizId, $questionNumber)
    {
        $quiz = Quiz::findOrFail($quizId);
        $question_count = QuizQuestion::where('quiz_id', $quizId)->count();
        $quiz_result = QuizQuestion::where('quiz_id', $quizId)->with('question.answers')->get()[$questionNumber - 1];
        // id для таблицы ответов на тест
        $quiz_question_id =  $quiz_result->id;
        $question = $quiz_result->question;
        // ответы для вопроса
        $answers = $question->answers;
        // отвеченные ответы, если есть
        $quiz_answers = QuizAnswer::where('quiz_question_id', $quiz_question_id)->get();

        return view('quiz.question', ['question' => $question, 'answers' => $answers, 'questionNumber' => $questionNumber, 'quizId' => $quizId, 'questionCount' => $question_count, 'quiz_question_id' => $quiz_question_id, 'is_completed' => $quiz_result->is_completed, 'quiz_answers' => $quiz_answers, 'quizTitle' => $quiz->template->name]);
    }

    /**
     * Валидирует и сохраняет ответ/ответы в БД, помечает вопрос как отвеченный
     *
     * @param Request $request
     * @param $quizId
     * @param $questionNumber
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeAnswer(Request $request, $quizId, $questionNumber){

        $request->validate([
            'answer' => 'required',
            'question' => 'required',
        ]);

        // Сохраняем ответ
        if(is_array($request->answer)){
            foreach ($request->answer as $answer){
                $this->insertAnswer($request->question, $answer);
            }
        } else {
            $this->insertAnswer($request->question, $request->answer);
        }

        // Помечаем вопрос как отвеченный
        $question = QuizQuestion::findOrFail($request->question);
        $question->is_completed = true;
        $question->save();


        // Перенаправляем на следующий вопрос, если он есть
        $question_count = QuizQuestion::where('quiz_id', $quizId)->count();
        if($question_count > $questionNumber){
            return redirect('quiz/'.$quizId.'/'.($questionNumber + 1));
        } else {
            return redirect('quiz/'.$quizId.'/'.$questionNumber);
        }

    }

    /**
     * Переводит тест в завешенное состояние, подсчитывает результаты
     *
     * @param $quizId
     * @return mixed
     */
    public function completeQuiz($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        if(!$quiz->is_completed){
            $quiz_questions = QuizQuestion::where('quiz_id', $quizId)->with('question')->with('quizAnswers.answer')->get();
            $correct_answers = 0;
            foreach ($quiz_questions as $quiz_question){
                // Для того что бы засчитался вопрос с чекбоксами нужно выбрать все правильные ответы.
                if($quiz_question->question->type === 'checkbox'){
                    $correct_answers_on_question = 0;
                    foreach($quiz_question['quizAnswers'] as $quizAnswer){
                        $correct_answers_on_question += $quizAnswer->answer->is_correct;
                    }
                    if($quiz_question->question->correct_answers === $correct_answers_on_question){
                        $correct_answers += 1;
                    }
                } else {
                    foreach($quiz_question['quizAnswers'] as $quizAnswer){
                        $correct_answers += $quizAnswer->answer->is_correct;
                    }
                }
            }
            $quiz->right_answers_count = $correct_answers;
            $quiz->is_completed = true;
            $quiz->save();
        }

        return redirect('quiz/'.$quizId.'/result');
    }

    /**
     * Показывает результаты теста
     *
     * @param $quizId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showResult($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        if(!$quiz->is_completed) {
            return redirect('quiz/' . $quizId . '/1');
        }

        return view('quiz.result', ['quiz_id' => $quiz->id, 'quizTitle' => $quiz->template->name,'quiz' => $quiz]);
    }

    /**
     *  Создает в базе новый тест
     *
     * @param $template
     * @return mixed
     */
    private function createNewQuiz($template) {
        $quiz = new Quiz();
        $quiz->quiz_template_id  = $template->id;
        $quiz->user_id  = Auth::id();
        $quiz->is_completed  = false;
        $quiz->save();
        return $quiz;
    }

    /**
     * Добавляет нужное количество вопросов из темы в тест
     *
     * @param $subject
     * @param $quiz_id
     * @return int
     */
    private function addSubjectToQuiz($subject, $quiz_id){
        $number_of_questions = $subject->pivot['number_of_questions'];
        $questions = Question::where('subject_id', $subject->id)->inRandomOrder()->take($number_of_questions)->get();
        foreach ($questions as $question) {
            $this->addQuestionToQuiz($question, $quiz_id);
        }

        return $number_of_questions;
    }

    /**
     * Добавляет вопрос в тест
     *
     * @param $question
     * @param $quiz_id
     */
    private function addQuestionToQuiz($question, $quiz_id) {
        $result = new QuizQuestion();
        $result->quiz_id = $quiz_id;
        $result->question_id = $question['id'];
        $result->is_completed = false;
        $result->save();
    }

    /**
     * Вставляет строку ответа в БД
     *
     * @param $question
     * @param $answer
     * @return bool
     */
    private function insertAnswer($question, $answer){
        $quiz_result = new QuizAnswer();
        $quiz_result->quiz_question_id = $question;
        $quiz_result->answer_id = $answer;
        return $quiz_result->save();
    }

}
