@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="card card-default">
                <div class="card-header">Доступные тесты</div>

                <div class="panel-body p-3">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Количество вопросов</th>
                                    <th>Темы</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($quizTemplates as $quizTemplate)
                                    <tr>
                                        <td>{{$quizTemplate->name}}</td>
                                        <td>{{$quizTemplate->questionsCount}}</td>
                                        <td>{{$quizTemplate->subjects->pluck('name')->implode(', ')}}</td>
                                        <td>
                                            <a href="{{ url('/quiz/create/' . $quizTemplate->id ) }}" title="Select"><button class="btn btn-success btn-sm">Пройти</button></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="float-right">
                            {{ $quizTemplates->links() }}
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
