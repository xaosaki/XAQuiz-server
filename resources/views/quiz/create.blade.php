@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 col-md-offset-2 text-center">
                <a href="{{ url('/quiz/'.$quiz_id.'/1') }}" class="btn btn-primary">Начать тест</a>
            </div>
        </div>
    </div>
@endsection
