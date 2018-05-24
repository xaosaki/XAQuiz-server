@extends('layouts.backend')

@section('content')
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Разрешения</div>
            <div class="card-body">
                <a href="{{ url('/admin/permissions/create') }}" class="btn btn-success btn-sm" title="Add New Permission">
                    <i class="fa fa-plus" aria-hidden="true"></i> Добавить новое
                </a>

                {!! Form::open(['method' => 'GET', 'url' => '/admin/permissions', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Поиск...">
                    <span class="input-group-append">
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
                                <th>ID</th><th>Название</th><th>Метка</th><th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td><td>{{ $item->label }}</td>
                                <td>
                                    <a href="{{ url('/admin/permissions/' . $item->id . '/edit') }}" title="Edit Permission"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Изменить</button></a>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'url' => ['/admin/permissions', $item->id],
                                        'style' => 'display:inline'
                                    ]) !!}
                                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Удалить', array(
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-sm',
                                                'title' => 'Delete Permission',
                                                'onclick'=>'return confirm("Удалить?")'
                                        )) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pagination"> {!! $permissions->appends(['search' => Request::get('search')])->render() !!} </div>
                </div>

            </div>
        </div>
    </div>
@endsection
