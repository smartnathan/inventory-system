<div class="form-group{{ $errors->has('supplier_id') ? 'has-error' : ''}}">
    {!! Form::label('supplier_id', 'Supplier', ['class' => 'control-label']) !!}
    {!! Form::select('supplier_id', $suppliers ,null, ('required' == 'required') ? ['class' => 'form-control chosen-select', 'required' => 'required'] : ['class' => 'form-control chosen-select']) !!}
    {!! $errors->first('supplier_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group{{ $errors->has('date_purchased') ? 'has-error' : ''}}" id="data_1">
    {!! Form::label('date_purchased', 'Date Purchased', ['class' => 'control-label']) !!}
    <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" required="required" class="form-control" value='{{ isset($purchaseorderheader)? $purchaseorderheader->date_purchased : date('d/m/Y', time()) }}' name="date_purchased">
        {!! $errors->first('date_purchased', '<p class="help-block">:message</p>') !!}

    </div>
</div>


<div class="form-group{{ $errors->has('total_amount') ? 'has-error' : ''}}">
    {!! Form::label('total_amount', 'Total Amount', ['class' => 'control-label']) !!}
    {!! Form::number('total_amount', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('total_amount', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('product_id') ? 'has-error' : ''}}">
    {!! Form::label('product_id', 'Product', ['class' => 'control-label']) !!}
    {!! Form::select('product_id', $products, (request('product')) ? request()->get('product') : "", ('' == 'required') ? ['class' => 'form-control chosen-select', 'required' => 'required'] : ['class' => 'form-control chosen-select']) !!}
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group{{ $errors->has('unit_price') ? 'has-error' : ''}}">
    {!! Form::label('unit_price', 'Unit Price', ['class' => 'control-label']) !!}
    {!! Form::number('unit_price', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('unit_price', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('quantity') ? 'has-error' : ''}}">
    {!! Form::label('quantity', 'Quantity', ['class' => 'control-label']) !!}
    {!! Form::number('quantity', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Re-Stock', ['class' => 'btn btn-primary']) !!}
</div>

