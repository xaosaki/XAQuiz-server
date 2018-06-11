@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="col-md-10">
                <div class="card card-default">
                    <div class="card-header">Пройденые тесты</div>

                    <div class="panel-body p-3">
                        <div class="row">
                            <div class="col-4">

                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Название</th>
                                    <th>Темы</th>
                                    <th>Сложность</th>
                                    <th>Результат</th>
                                    <th>Действие</th>
                                </tr>
                                @foreach($quizzes as $quiz)
                                    <tr>
                                        <td>{{$quiz->template->name}}</td>
                                        <td> {{$quiz->template->subjects->pluck('name')->implode(', ')}}</td>
                                        <td>{{($quiz->complexity_level > 0) ? Config::get('enums.complexity_levels')[$quiz->complexity_level] : 'Случайная'}}</td>
                                        <td>{{$quiz->right_answers_count}}/{{$quiz->questions_count}}</td>
                                        <td>
                                            <a href="{{ url('/quiz/' . $quiz->id .'/result') }}" title="Select"><button class="btn btn-success btn-sm">Подробнее</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="float-right">
                            {{ $quizzes->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
