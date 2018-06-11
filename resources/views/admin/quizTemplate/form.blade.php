<div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
    {!! Form::label('name', 'Название: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group{{ $errors->has('description') ? ' has-error' : ''}}">
    {!! Form::label('description', 'Описание: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-12">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required', 'rows'=>"5"]) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group{{ $errors->has('subjects') ? ' has-error' : ''}}">
    {!! Form::label('subjects', 'Темы: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('subjects', null, ['class' => 'form-control visually-hidden' , 'id' => 'subjectsContainer']) !!}
        {!! $errors->first('subjects', '<p class="help-block">:message</p>') !!}

        <div id="quiz-template-subjects" data-subjects='{{$subjects}}'>
            <div class="buttons-group">
                <button type="button" class="btn btn-warning btn-sm" id="create">Добавить</button>
            </div>
        </div>
        <div class="error-block">

        </div>
        <div class="part-form-save-block">
            <i><small>Для сохранения информации о темах, необходимо ваше подтверждение: </small></i>
            <button type="button" class="btn btn-success btn-sm" style="
      margin-left: 10px;" id="saveSubjects">Подтвердить</button>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">

        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Создать', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
