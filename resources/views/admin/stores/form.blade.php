<div class="row">
    <div class="col-md-4 form-group{{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div style="margin: 0px 5px 0px 5px" class="col-md-4 form-group{{ $errors->has('address') ? 'has-error' : ''}}">
    {!! Form::label('address', 'Address', ['class' => 'control-label']) !!}
    {!! Form::text('address', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
</div>

<div class="col-md-4 form-group{{ $errors->has('mobile_number') ? 'has-error' : ''}}">
    {!! Form::label('mobile_number', 'Mobile Number', ['class' => 'control-label']) !!}
    {!! Form::text('mobile_number', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('mobile_number', '<p class="help-block">:message</p>') !!}
</div>
</div>
<div class="row">
    <div style="margin-right: 5px" class="col-md-6 form-group{{ $errors->has('location') ? 'has-error' : ''}}">
    {!! Form::label('location', 'Location', ['class' => 'control-label']) !!}
    {!! Form::text('location', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
</div>
<div class="col-md-6 form-group{{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Add', ['class' => 'btn btn-primary']) !!}
</div>
