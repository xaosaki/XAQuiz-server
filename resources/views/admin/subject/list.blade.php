@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-md-offset-1">
                <div class="card card-default">
                    <div class="card-header clearfix">
                        <h4 class="pull-left">Категории вопросов</h4>
                        <a href="{{ route('admin.subject.create') }}" class="btn btn-primary pull-right navigation-buttons">Добавить</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach($subjects as $subject)
                                <tr>
                                    <th>{{$subject->id}}</th>
                                    <td>{{$subject->name}}</td>
                                    <td>
                                        <form action="{{route('admin.subject.destroy', ['subject' => $subject->id])}}" method="post">
                                            {{csrf_field()}}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger pull-right" style="margin-left: 20px" type="submit" onclick="return confirm('Удалить категорию?')">Удалить</button>
                                            <a href="{{ route('admin.subject.edit', ['subject' => $subject->id]) }}" class="btn btn-default pull-right">Изменить</a>
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
