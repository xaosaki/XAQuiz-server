@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form method="post" action="{{route('admin.subject.store')}}">
                <div class="col-md-6 col-md-offset-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <h4 class="pull-left">Новая категория вопросов</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                {{ csrf_field() }}
                                <label for="name">Название:</label>
                                <input type="text" class="form-control" id="name" name="name"/>
                            </div>
                            <a href="{{route('admin.subject.index')}}" class="btn btn-default">Назад</a>
                            <button type="submit" class="btn btn-primary pull-right">Добавить</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
