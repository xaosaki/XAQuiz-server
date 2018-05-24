@extends('layouts.common')

@section('page')
        <div class="container">
            <div class="row">
                @include('admin.sidebar')
                @yield('content')
            </div>
        </div>
@endsection