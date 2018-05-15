@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form method="post" action="{{route('admin.quiz-template.store')}}">
                {{ csrf_field() }}
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
                            <h4 class="pull-left">Новый шаблон теста</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">Название:</label>
                                <input type="text" class="form-control" id="name" name="name"/>
                            </div>

                            <div class="form-group">
                                <label for="subjects">Темы(JSON):</label>
                                <input type="text" class="form-control" id="subjects" name="subjects" placeholder='{"0":{"id":"2","questionsCount":"1"}, "1":{"id":"1","questionsCount":"2"}}' value='{"0":{"id":"2","questionsCount":"1"}, "1":{"id":"1","questionsCount":"2"}}'/>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<select multiple name="">--}}
                                    {{--@foreach($subjects as $subject)--}}
                                        {{--<option value="{{$subject->id}}">{{$subject->name}}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            <a href="{{route('admin.subject.index')}}" class="btn btn-default">Назад</a>
                            <button type="submit" class="btn btn-primary pull-right">Добавить</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
