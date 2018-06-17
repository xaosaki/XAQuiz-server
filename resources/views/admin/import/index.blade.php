@extends('layouts.backend')

@section('content')
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Вопросы</div>
            <div class="card-body">
                <a href="{{ route('admin.question.index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br>
                <br>
                {!! $message !!}
                <br>
                <form action="{{ route('admin.import-question-post') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="questions" class="">
                    <button class="btn btn-primary">Импортировать</button>
                </form>
            </div>
        </div>
    </div>
@endsection
