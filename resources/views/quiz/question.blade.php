@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3>{{$quizTitle}}</h3>
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h4 class="pull-left">Вопрос {{$questionNumber}}</h4>
                        <div class="navigation-buttons pull-right">
                            @if($questionNumber > 1)
                                <a href="{{ url('/quiz/'.$quizId.'/'.($questionNumber - 1)) }}" class="btn btn-secondary"><</a>
                            @else
                                <a class="btn btn-secondary" disabled><</a>
                            @endif
                            @if($questionNumber < $questionCount)
                                <a href="{{ url('/quiz/'.$quizId.'/'.($questionNumber + 1)) }}" class="btn btn-secondary">></a>
                            @else
                                <a class="btn btn-secondary" disabled>></a>
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
                        <h5>{{$question['text']}}</h5>
                        <form method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="question" value="{{$quiz_question_id}}">
                            @switch($question['type'])
                                @case('checkbox')
                                    @include('quiz.answers.checkbox', ['answers' => $answers, 'quiz_answers' => $quiz_answers, $is_completed])
                                    @break
                                @case('radio')
                                    @include('quiz.answers.radio', ['answers' => $answers,  'quiz_answers' => $quiz_answers, $is_completed])
                                    @break
                            @endswitch
                            @if($questionNumber < $questionCount)
                                @if(!$is_completed)
                                    <button class="btn btn-primary">Ответить и перейти к следующему вопросу</button>
                                @else
                                    <button class="btn btn-primary" disabled>Ответ принят</button>
                                @endif
                            @else
                                <a href="{{ url('/quiz/'.$quizId.'/complete') }}" class="btn btn-success pull-right">Завершить тест</a>
                                @if(!$is_completed)
                                    <button class="btn btn-primary">Ответить</button>
                                @else
                                    <button class="btn btn-primary" disabled>Ответ принят</button>
                                @endif
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
