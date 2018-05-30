@extends('layouts.backend')

@section('content')
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Тесты</div>
            <div class="card-body">
                {!! Form::open(['method' => 'GET', 'url' => '/admin/quiz', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Поиск...">
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                {!! Form::close() !!}

                <br/>
                <br/>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Количество вопросов</th>
                            <th>Пользователь</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($quizzes as $quiz)
                            <tr>
                                <th>{{$quiz->id}}</th>
                                <td>{{$quiz->template->name}}</td>
                                <td>{{$quiz->questions_count}}</td>
                                <td>{{$quiz->user->name}}</td>
                                <td>{{$quiz->is_completed ? 'завершен' : 'создан' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
