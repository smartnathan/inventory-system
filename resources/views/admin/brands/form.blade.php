
<div class="form-group{{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('manufacturer_id') ? 'has-error' : ''}}">
    {!! Form::label('manufacturer_id', 'Product', ['class' => 'control-label']) !!}
    {!! Form::select('manufacturer_id', $manufacturers, null, ['class' => 'form-control chosen-select', 'required' => 'required']) !!}
    {!! $errors->first('manufacturer_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
