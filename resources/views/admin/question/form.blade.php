<div class="form-group{{ $errors->has('subject_id') ? ' has-error' : ''}}">
    {!! Form::label('subject_id', 'Категория: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {{ Form::select('subject_id', $subjects, null, ['class' => 'form-control', 'required' => 'required']) }}
        {!! $errors->first('subject_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group{{ $errors->has('complexity_level') ? ' has-error' : ''}}">
    {!! Form::label('complexity_level', 'Сложность: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {{ Form::select('complexity_level', Config::get('enums.complexity_levels'), null, ['class' => 'form-control', 'required' => 'required']) }}
        {!! $errors->first('complexity_level', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
    {!! Form::label('text', 'Формулировка вопроса: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-12">
        {!! Form::textarea('text', null, ['class' => 'form-control', 'required' => 'required', 'rows' => '3']) !!}
        {!! $errors->first('text', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group{{ $errors->has('answers') ? ' has-error' : ''}}">
    {!! Form::label('answers', 'Ответы: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-12">
        {!! Form::text('answers', null, ['class' => 'form-control visually-hidden' , 'id' => 'answersContainer']) !!}
        {!! $errors->first('answers', '<p class="help-block">:message</p>') !!}

        <div id="quiz-template-answers">
            <div class="buttons-group">
                <button type="button" class="btn btn-warning btn-sm" id="create">Добавить</button>
            </div>
        </div>
        <div class="error-block">

        </div>
        <div class="part-form-save-block">
            <i><small>Для сохранения ответов, необходимо ваше подтверждение: </small></i>
            <button type="button" class="btn btn-success btn-sm" style="
      margin-left: 10px;" id="saveAnswers">Подтвердить</button>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">

        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Сохранить', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
