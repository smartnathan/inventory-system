<div class="form-group{{ $errors->has('customer_id') ? 'has-error' : ''}}">
    {!! Form::label('customer_id', 'Customer', ['class' => 'control-label']) !!}
    <select name="customer_id" class="form-control select2_demo_1" required="required">
        <option value="">Choose a Customer</option>
            @if ($customers)
@foreach($customers as $user)
<option value="{{ $user->id }}">{{ $user->name }} : {{ $user->mobile_number }}</option>
@endforeach
    @endif
    </select>
    {!! $errors->first('customer_id', '<p class="help-block">:message</p>') !!}
</div>





<div class="">
                <h1></i>Item(s) Sold</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="pricing-list-container" style="width:100%;">
                        <tr>
                            <td>
                                <span style="font-weight: bold">Product</span>
                                <span style="margin-left: 520px; font-weight: bold">Quantity</span>
                                <span style="margin-left: 120px; font-weight: bold">Payment Status</span>

                            </td>
                        </tr>

                        <tr class="pricing-list-item">
                            <td>
                                <div class="row">

                                    <div class="col-md-6">
<div class="form-group{{ $errors->has('product_id') ? 'has-error' : ''}}">
    <select name="product_id[]" class="form-control select2_demo_" required="required">
        <option value="">Choose a product</option>
            @if ($stocks)
@foreach($stocks as $stock)
<option value="{{ $stock->product_id }}, {{ $stock->id }}">{{ $stock->product->name }} - {{ $stock->product->manufacturer->name }}</option>
@endforeach
    @endif
    </select>
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-grou">
                                            <input type="number" class="form-control" placeholder="Quanity" name="quantity[]">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-grou">
<select name="is_paid[]" id="" class="form-control">
    <option value="">--Payment Status--</option>
    <option value="1">Paid</option>
    <option value="0">Not Paid</option>
</select>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <a class="delete btn btn-danger btn-rounded" href="#"><i class="fa fa-fw fa-remove"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    </div>
                    <a href="#0" class="btn btn-success btn-rounded add-pricing-list-item"><i class="fa fa-fw fa-plus-circle"></i>Add Item</a>
            </div>
            <!-- /row-->





<div class="form-group{{ $errors->has('remark') ? 'has-error' : ''}}">
    {!! Form::label('remark', 'Remark', ['class' => 'control-label']) !!}
    {!! Form::textarea('remark', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Make Sale', ['class' => 'btn btn-primary']) !!}
</div>

@section('scripts')
<script>
    $(document).ready(function(){
// Pricing add
    function newMenuItem() {
        var newElem = $('tr.pricing-list-item').first().clone();
        newElem.find('input[type=number]').val('');
        newElem.find('select').val('');
        newElem.find('select').addClass('chosen-select');
        newElem.find('input[type=radio]').prop('checked', false); // Unchecks it
        newElem.appendTo('table#pricing-list-container');
    }
    if ($("table#pricing-list-container").is('*')) {
        $('.add-pricing-list-item').on('click', function (e) {
            e.preventDefault();
            newMenuItem();
        });
        $(document).on("click", "#pricing-list-container .delete", function (e) {
            e.preventDefault();
            $(this).parent().parent().parent().remove();
        });
    }
    });
</script>
@endsection
