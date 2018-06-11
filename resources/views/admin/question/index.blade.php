@extends('layouts.backend')

@section('content')
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Вопросы</div>
            <div class="card-body">
                <a href="{{ route('admin.question.create') }}" class="btn btn-success btn-sm" title="Add New">
                    <i class="fa fa-plus" aria-hidden="true"></i> Добавить
                </a>

                {!! Form::open(['method' => 'GET', 'url' => '/admin/question', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Поиск...">
                    <span class="input-group-btn">
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
                            <th>Текст</th>
                            <th>Категория</th>
                            <th>Уровень сложности</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($questions as $item)
                            <tr>
                                <td>{{ $item->text }}</td>
                                <td>{{ $item->subjects->name }}</td>
                                <td>{{ ($item->complexity_level) ? Config::get('enums.complexity_levels')[$item->complexity_level] : 'Не указано'}}</td>
                                <td>
                                    <a href="{{ url('/admin/question/' . $item->id . '/edit') }}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Изменить</button></a>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'url' => ['/admin/question', $item->id],
                                        'style' => 'display:inline'
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Удалить', array(
                                            'type' => 'submit',
                                            'class' => 'btn btn-danger btn-sm',
                                            'title' => 'Delete',
                                            'onclick'=>'return confirm("Удалить?")'
                                    )) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
