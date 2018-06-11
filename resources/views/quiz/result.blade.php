@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-md-offset-1">
                <div class="card card-default  text-center">
                    <div class="card-header">
                        <h3>Результаты тестирования</h3>
                    </div>
                    <div class="card-body text-center">
                        <ul>
                            <li>
                                Тема теста: {{$quizTitle}}</li>
                            <li>
                                Статус: Завершен</li>
                            <li>
                                Количество вопросов: {{$quiz->questions_count}}</li>
                            <li>
                                Правильных ответов: {{$quiz->right_answers_count}}</li>
                            <li>
                                Оценка: Отлично</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
