@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h4 class="pull-left">Тесты</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Количество вопросов</th>
                                    <th>Пользователь</th>
                                    <th>Статус</th>
                                </tr>
                            </thead>
                            @foreach($quizzes as $quiz)
                                <tr>
                                    <th>{{$quiz->id}}</th>
                                    <td>{{$quiz->template->name}}</td>
                                    <td>{{$quiz->questions_count}}</td>
                                    <td>{{$quiz->user->name}}</td>
                                    <td>{{$quiz->is_completed ? 'завершен' : 'создан' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
