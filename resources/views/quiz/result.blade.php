@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-md-offset-1">
                <div class="card card-default  text-center">
                    <div class="card-header">
                        <h3>{{$quizTitle}} [Завершен]</h3>
                    </div>
                    <div class="card-body text-center">
                        <h4>Тест завершен</h4>
                        <h2>Результат:</h2>
                        <h1>{{$quiz->right_answers_count}} из {{$quiz->questions_count}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
