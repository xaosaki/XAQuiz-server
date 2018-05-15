@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <a href="{{ url('/quiz/'.$quiz_id.'/1') }}" class="btn btn-primary">Начать тест</a>
            </div>
        </div>
    </div>
@endsection
