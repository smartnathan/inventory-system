<div class="row">
	<div class="col-md-4 form-group{{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
</div>

<div class="row">
	<div class="col-md-4 form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Add', ['class' => 'btn btn-primary']) !!}
</div>
</div>
