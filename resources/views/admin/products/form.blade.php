<div class="row">
    <div class="form-group{{ $errors->has('name') ? 'has-error' : ''}} col-md-4">
    {!! Form::label('name', 'Name or Model', ['class' => 'control-label']) !!}
    <span class="text-danger">*</span>
    {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
{{-- <div class="form-group{{ $errors->has('brand_id') ? 'has-error' : ''}}">
    {!! Form::label('brand_id', 'Model', ['class' => 'control-label']) !!}
    {!! Form::select('brand_id', $brands, null, ('required' == 'required') ? ['class' => 'form-control select2_demo', 'required' => 'required'] : ['class' => 'form- chosen-select']) !!}
    {!! $errors->first('brand_id', '<p class="help-block">:message</p>') !!}
</div> --}}
<style type="text/css">
    
</style>
<div class="form-group{{ $errors->has('manufacturer_id') ? 'has-error' : ''}} col-md-4" style="margin-left: 5px! important">
    {!! Form::label('manufacturer_id', 'Products', ['class' => 'control-label']) !!}
    <span class="text-danger">*</span>
    {!! Form::select('manufacturer_id', $manufacturers, null, ('required' == 'required') ? ['class' => 'form-control select2_demo change-height', 'required' => 'required'] : ['class' => 'form- chosen-select']) !!}
    {!! $errors->first('manufacturer_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('category_id') ? 'has-error' : ''}} col-md-4" style="margin-left: 5px! important">
    {!! Form::label('category_id', 'Category', ['class' => 'control-label']) !!}
    <span class="text-danger">*</span>
    {!! Form::select('category_id', $categories, null, ['class' => 'form-control select2_demo', 'required' => 'required']) !!}
    {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
</div>
</div>

<div class="row">
    <div class="form-group{{ $errors->has('store_id') ? 'has-error' : ''}} col-md-4">
    {!! Form::label('stores', 'Store(s)', ['class' => 'control-label']) !!}
    <span class="text-danger">*</span>
    {!! Form::select('stores[]', $stores, null, ['class' => 'select2_demo_3 form-control', 'required' => 'required', 'multiple' => true]) !!}
    {!! $errors->first('stores', '<p class="help-block">:message</p>') !!}
</div>

{{-- <div class="form-group{{ $errors->has('image') ? 'has-error' : ''}}">
    {!! Form::label('image', 'Image', ['class' => 'control-label']) !!}
    {!! Form::text('image', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
</div> --}}
<div class="form-group{{ $errors->has('cost_price') ? 'has-error' : ''}} col-md-4" style="margin-left: 5px! important">
    {!! Form::label('cost_price', 'Cost Price (RMB)', ['class' => 'control-label']) !!}
    <span class="text-danger">*</span>
    {!! Form::text('cost_price', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('cost_price', '<p class="help-block">:message</p>') !!}
</div>
{{-- <div class="form-group{{ $errors->has('unit_of_measurement_id') ? 'has-error' : ''}}">
    {!! Form::label('unit_of_measurement_id', 'Unit Of Measurement', ['class' => 'control-label']) !!}
    {!! Form::select('unit_of_measurement_id', $units, 1, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('unit_of_measurement_id', '<p class="help-block">:message</p>') !!}
</div> --}}
<div class="form-group{{ $errors->has('description') ? 'has-error' : ''}} col-md-4" style="margin-left: 5px! important">
    {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}

    {!! Form::textarea('description', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'rows' => 2] : ['class' => 'form-control']) !!}
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
{{-- <div class="form-group{{ $errors->has('is_active') ? 'has-error' : ''}}">
    {!! Form::label('is_active', 'Display Status', ['class' => 'control-label']) !!}
    <div class="checkbox">
    <label>{!! Form::radio('is_active', '1', true) !!} Available</label>
</div>
<div class="checkbox">
    <label>{!! Form::radio('is_active', '0' ) !!} Unavailable</label>
</div>
    {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
</div>--}}
</div>

        <strong style="font-size: 17px">Other Product Information</strong>
<hr />
 
<div class="row">
    
    <div class="form-group{{ $errors->has('wholesale_min_quantity') ? 'has-error' : ''}} col-md-4">
    {!! Form::label('wholesale_min_quantity', 'Wholesale Min Quantity', ['class' => 'control-label']) !!}
    {!! Form::number('wholesale_min_quantity', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('wholesale_min_quantity', '<p class="help-block">:message</p>') !!}
</div>
{{-- <div class="form-group{{ $errors->has('retail_price') ? 'has-error' : ''}}">
    {!! Form::label('retail_price', 'Retail Price (₦)', ['class' => 'control-label']) !!}
    {!! Form::number('retail_price', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('retail_price', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('whole_sale_price') ? 'has-error' : ''}}">
    {!! Form::label('whole_sale_price', 'Whole Sale Price (₦)', ['class' => 'control-label']) !!}
    {!! Form::number('whole_sale_price', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('whole_sale_price', '<p class="help-block">:message</p>') !!}
</div> --}}

<div class="form-group{{ $errors->has('quantity_in_hand') ? 'has-error' : ''}} col-md-4" style="margin-left: 5px! important">
    {!! Form::label('quantity_in_hand', 'Quantity in hand for store or each store', ['class' => 'control-label']) !!}
    {!! Form::number('quantity_in_hand', (isset($product)) ? $product->stock->quantity_in_hand : null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('quantity_in_hand', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('re_order_quantity') ? 'has-error' : ''}} col-md-4" style="margin-left: 5px! important">
    {!! Form::label('re_order_quantity', 'Re-order Quantity', ['class' => 'control-label']) !!}
    {!! Form::number('re_order_quantity', (isset($product)) ? $product->stock->re_order_quantity : null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('re_order_quantity', '<p class="help-block">:message</p>') !!}
</div>
</div>
<div class="form-group{{ $errors->has('remark') ? 'has-error' : ''}}">
    {!! Form::label('remark', 'Remark', ['class' => 'control-label']) !!}
    {!! Form::textarea('remark', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'rows' => 2] : ['class' => 'form-control']) !!}
    {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update Product' : 'Add Product', ['class' => 'btn btn-primary']) !!}
</div>
