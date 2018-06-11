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


        {{--<div class="col-md-10 col-md-offset-1">--}}
            {{--<div class="card card-default">--}}
                {{--<div class="card-header">Доступные тесты</div>--}}

                {{--<div class="panel-body p-3">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-4">--}}
                                {{----}}
                            {{--</div>--}}
                        {{--</div>--}}


                        {{--<div class="table-responsive">--}}
                            {{--<table class="table">--}}
                                {{--<tr>--}}
                                    {{--<th>Название</th>--}}
                                    {{--<th>Количество вопросов</th>--}}
                                    {{--<th>Темы</th>--}}
                                    {{--<th>Действие</th>--}}
                                {{--</tr>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                        {{--<div class="float-right">--}}
                            {{--{{ $quizTemplates->links() }}--}}
                        {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
</div>
@endsection
