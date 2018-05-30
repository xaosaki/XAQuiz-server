@extends('layouts.backend')

@section('content')
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Добавить новый вопрос</div>
            <div class="card-body">
                <a href="{{ route('admin.question.index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br />
                <br />

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                {!! Form::open(['url' => '/admin/question', 'class' => 'form-horizontal']) !!}

                @include ('admin.question.form')

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection
