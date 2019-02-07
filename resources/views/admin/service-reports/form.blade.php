
<div class="form-group{{ $errors->has('service_id') ? 'has-error' : ''}}">
    {!! Form::label('service_id', 'Service', ['class' => 'control-label']) !!}
    {!! Form::select('service_id', $services, null, ['class' => 'form-control chosen-select']) !!}
    {!! $errors->first('service_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('customer_id') ? 'has-error' : ''}}">
    {!! Form::label('customer_id', 'Customer', ['class' => 'control-label']) !!}
    <select name="customer_id" class="chosen-select form-control" required="required">
        <option value="">Choose a Customer</option>
            @if ($customers)
@foreach($customers as $user)
<option {{(isset($servicereport) && $servicereport->customer_id == $user->id) ? 'selected' : ''}} value="{{ $user->id }}">{{ $user->name }} : {{ $user->mobile_number }}</option>
@endforeach
    @endif
    </select>
    {!! $errors->first('customer_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('extra_charges') ? 'has-error' : ''}}">
    {!! Form::label('extra_charges', 'Extra Charges', ['class' => 'control-label']) !!}
    {!! Form::number('extra_charges', null, ['class' => 'form-control']) !!}
    {!! $errors->first('extra_charges', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('reasons') ? 'has-error' : ''}}">
    {!! Form::label('reasons', 'State Reason(s)', ['class' => 'control-label']) !!}
    {!! Form::textarea('reasons', null, ['class' => 'form-control']) !!}
    {!! $errors->first('reasons', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update Report' : 'Submit Report', ['class' => 'btn btn-primary']) !!}
</div>
