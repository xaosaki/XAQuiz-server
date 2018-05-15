@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h4 class="pull-left">Шаблоны тестов</h4>
                        <a href="{{ route('admin.quiz-template.create') }}" class="btn btn-primary pull-right navigation-buttons">Добавить</a>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Количество вопросов</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach($quizTemplates as $quizTemplate)
                                <tr>
                                    <th>{{$quizTemplate->id}}</th>
                                    <td>{{$quizTemplate->name}}</td>
                                    <td>{{$quizTemplate->questionsCount}}</td>
                                    <td>
                                        <form action="{{route('admin.quiz-template.destroy', ['subject' => $quizTemplate->id])}}" method="post">
                                            {{csrf_field()}}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger pull-right" style="margin-left: 20px" type="submit" onclick="return confirm('Удалить категорию?')">Удалить</button>
                                            <a href="{{ route('admin.quiz-template.edit', ['subject' => $quizTemplate->id]) }}" class="btn btn-default pull-right">Изменить</a>
                                        </form>
                                        </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
