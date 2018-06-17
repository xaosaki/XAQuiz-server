@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 col-md-offset-2">
                <div class="quiz-info card">
                    <div class="card-header">
                        Информация о тесте
                    </div>
                    <div class="card-body">
                        <div class="quiz-info__title">
                            {{$quiz_template->name}}
                        </div>
                        <div class="quiz-info__description">
                            {{$quiz_template->description}}
                        </div>
                        <form action="{{url('/quiz/create')}}" method="POST">
                            @csrf
                            <input type="text" name="id" value="{{$quiz_template->id}}" hidden>
                            <div class="col-12">
                                <div class="quiz-info__form row">
                                    {!! Form::label('complexity_level', 'Выберите сложность вопросов: ', ['class' => 'col-md-3 control-label']) !!}
                                    {{ Form::select('complexity_level', $complexity_levels, null, ['class' => 'form-control col-md-3', 'required' => 'required', 'style' => 'margin-bottom: 10px;']) }}
                                    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Начать тест', ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
