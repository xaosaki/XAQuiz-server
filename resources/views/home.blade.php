@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @foreach($quizTemplates as $quizTemplate)
            <div class="col-md-4 quiz-card">
                <div class="card">
                    <div class="quiz-card__header">
                        {{$quizTemplate->name}}
                    </div>
                    <div class="quiz-card__body">
                        Количество вопросов: {{$quizTemplate->questionsCount}}
                        <br>
                        Темы: {{$quizTemplate->subjects->pluck('name')->implode(', ')}}
                        <br>
                        <a href="{{ url('/quiz/info/' . $quizTemplate->id ) }}" title="Select"><button class="btn btn-default btn-sm">Подробнее</button></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
