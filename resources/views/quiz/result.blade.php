@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-md-offset-1">
                <div class="card card-default  text-center results">
                    <div class="card-header">
                        <h3>Результаты тестирования</h3>
                    </div>
                    <div class="card-body results__body">
                        <ul class="results__list">
                            <li>
                                Тема теста: {{$quizTitle}}</li>
                            <li>
                                Статус: Завершен</li>
                            <li>
                                Сложность: {{($quiz->complexity_level > 0) ? Config::get('enums.complexity_levels')[$quiz->complexity_level] : 'Случайная'}}</li>
                            <li>
                                Количество вопросов: {{$quiz->questions_count}}</li>
                            <li>
                                Правильных ответов: {{$quiz->right_answers_count}}</li>
                            <li>
                                Оценка: {{$quiz['mark']}}</li>
                        </ul>
                        <div class="results__chart">
                            <canvas id="myChart" class="js-result-chart" data-correct="{{$percents['correct']}}" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
