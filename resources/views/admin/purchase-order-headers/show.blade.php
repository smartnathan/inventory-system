@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">PurchaseOrderHeader {{ $purchaseorderheader->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/purchase-order-headers') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/purchase-order-headers/' . $purchaseorderheader->id . '/edit') }}" title="Edit PurchaseOrderHeader"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/purchaseorderheaders', $purchaseorderheader->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete PurchaseOrderHeader',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $purchaseorderheader->id }}</td>
                                    </tr>
                                    <tr><th> Supplier Id </th><td> {{ $purchaseorderheader->supplier_id }} </td></tr><tr><th> Date Purchased </th><td> {{ $purchaseorderheader->date_purchased }} </td></tr><tr><th> Total Amount </th><td> {{ $purchaseorderheader->total_amount }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
