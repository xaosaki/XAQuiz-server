@extends('layouts.backend')

@section('content')
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Изменить категорию вопросов</div>
            <div class="card-body">
                <a href="{{ route('admin.subject.index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br />
                <br />

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                {!! Form::model($subject, [
                    'method' => 'PATCH',
                    'url' => ['/admin/subject', $subject->id],
                    'class' => 'form-horizontal'
                ]) !!}

                @include ('admin.subject.form', ['submitButtonText' => 'Сохранить'])

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection
