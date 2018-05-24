@extends('layouts.backend')

@section('content')
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Создать новый шаблон теста</div>
            <div class="card-body">
                <a href="{{ route('admin.quiz-template.index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br />
                <br />

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                {!! Form::open(['url' => '/admin/quiz-template', 'class' => 'form-horizontal']) !!}

                @include ('admin.quizTemplate.form')

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection
