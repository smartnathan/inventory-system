@extends('layouts.master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Sales Report</h2>
        <ol class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a>Sales</a>
            </li>
            <li class="active">
                <strong>All Sales Report</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">

        <div class="ibox-title">


            <div class="ibox-tools">

                {{-- <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-wrench"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#">Config option 1</a>
                    </li>
                    <li><a href="#">Config option 2</a>
                    </li>
                </ul>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a> --}}
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-5 m-b-xs">
                    {{-- <select class="input-sm form-control input-s-sm inline">
                    <option value="0">Option 1</option>
                    <option value="1">Option 2</option>
                    <option value="2">Option 3</option>
                    <option value="3">Option 4</option>
                </select> --}}
                </div>
                <div class="col-sm-4 m-b-xs">
                    {{-- <div data-toggle="buttons" class="btn-group">
                        <label class="btn btn-sm btn-white"> <input type="radio" id="option1" name="options"> Day </label>
                        <label class="btn btn-sm btn-white active"> <input type="radio" id="option2" name="options"> Week </label>
                        <label class="btn btn-sm btn-white"> <input type="radio" id="option3" name="options"> Month </label>
                    </div> --}}
                </div>
                <div class="col-sm-3">
                        {{-- {!! Form::open(['method' => 'GET', 'url' => '/admin/customers', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="search" placeholder="Search" value="{{ request('search') }}">
                            <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary"> Go!</button>
                            </span>
                        </div>
                        {!! Form::close() !!} --}}

                        {!! Form::open(['method' => 'GET', 'url' => '/admin/reports/sales', 'role' => 'search'])  !!}
            <div class="text-right">
                <div class="input-group">
                    <select class="input-sm form-control" name="search" id="report-type">
                        <option value="">--Report Type--</option>
                        <option {{(request('search') == 'today') ? 'selected' : ''}} value="today">Today</option>
                        <option {{(request('search') == 'yesterday') ? 'selected' : ''}} value="yesterday">Yesterday</option>
                        <option {{(request('search') == 'thisweek') ? 'selected' : ''}} value="thisweek">This Week</option>
                        <option {{(request('search') == 'lastweek') ? 'selected' : ''}} value="lastweek">Last Week</option>
                        <option {{(request('search') == 'thismonth') ? 'selected' : ''}} value="thismonth">This Month</option>
                        <option {{(request('search') == 'lastmonth') ? 'selected' : ''}} value="lastmonth">Last Month</option>
                        <option {{(request('search') == 'thisyear') ? 'selected' : ''}} value="thisyear">This Year</option>
                        <option {{(request('search') == 'lastyear') ? 'selected' : ''}} value="lastyear">Last Year</option>
                    </select>
                    <span class="input-group-btn"><button class="btn btn-sm btn-primary" type="submit">Filter</button></span>
                </div>
            </div>
            {!! Form::close() !!}
                </div>
            </div>
            <div class="table-responsive">
                @if ($orders->count() == 0)
                    <div class="alert alert-danger">No data was found!</div>

                @else
                <table class="table table-striped">
                    <thead>
                                        <tr>
                                            <th>Payment Status</th>
                                            <th>Product</th>
                                            <th>Brand</th>
                                            <th>Quantity</th>
                                            <th>Unit Price (₦)</th>
                                            <th>Total (₦)</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $item)
                                        <tr>
                                            <td>
                                                @if ($item->is_paid == 1)
                                                <span class="label label-primary"><i class="fa fa-check"></i> Completed</span>
                                                @else
                                                <span class="label label-danger"><i class="fa fa-times"></i> Not Paid</span>
                                                @endif
                                            </td>
                                            <td>
                                               {{ $item->product->name }}
                                            </td>
                                            <td>
                                                {{ $item->product->brand->manufacturer->name }}
                                            </td>
                                            <td>
                                               {{ $item->quantity }}
                                            </td>
                                            <td>
                @if ($item->quantity >= $item->product->wholesale_min_quantity)
                            {{ $item->product->whole_sale_price}}
                        @else
                        {{ $item->product->retail_price }}
                        @endif
                                            </td>
                                            <td>
                                            @if ($item->quantity >= $item->product->wholesale_min_quantity)
                                            @php
                                            $total += $item->product->whole_sale_price * $item->quantity
                                            @endphp
                            {{ $item->product->whole_sale_price * $item->quantity}}.00
                        @else
                        @php
                        $total += $item->product->retail_price  * $item->quantity;
                        @endphp
                        {{ $item->product->retail_price  * $item->quantity }}.00
                        @endif
                                            </td>

                                        </tr>
                                        @endforeach

                                        </tbody>
                </table>
                @endif
                                                    <hr />
<div class="lead text-right">Grand Total (₦) = {{ $total }}.00</div>
<hr />
@if(empty(request('search')))
                <div class="pagination-wrapper"> {!! $orders->appends(['search' => Request::get('search')])->render() !!} </div>
                @endif
            </div>

        </div>
    </div>
</div>
</div>



@endsection
