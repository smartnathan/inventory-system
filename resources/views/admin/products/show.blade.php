@extends('layouts.master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-sm-4">
<h2>Product's details</h2>
<ol class="breadcrumb">
<li>
<a href="/admin">Home</a>
</li>
<li class="active">
<strong>Product's detail</strong>
</li>
</ol>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="wrapper wrapper-content animated fadeInUp">
<div class="ibox">
<div class="ibox-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="m-b-md">
                {{-- <a  href="{{ url('/admin/products/' . $products->id . '/edit') }}" title="Edit products" class="btn btn-white btn-xs pull-right"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit products</a> --}}
                <a  href="#" title="Edit products" class="btn btn-white btn-xs pull-right"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit products</a>
                <h2><a href="{{ url('/admin/products') }}" title="Back"><button class="btn btn-primary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a> {{ $product->manufacturer->name }} {{ $product->name }}</h2>
            </div>
            <dl class="dl-horizontal">
                <dt>Status:</dt> <dd><span class="label label-primary">Active</span></dd>
            </dl>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <dl class="dl-horizontal">
                <dt>Category:</dt> <dd>{{ $product->category->name }}</dd>
                <br>
                <dt>Added By:</dt> <dd>{{ $product->user->name }}</dd>
                <br>
                <dt>Product's Code:</dt> <dd>  {{ $product->code }} </dd>
                <br>
                <dt>Product's Cost Price:</dt> <dd>  {{ $product->cost_price }} </dd>
                <br>
                <dl class="dl-horizontal" >

                    <dt>Date Added:</dt> <dd> {{ date('d.m.Y h:i:s a', strtotime($product->created_at)) }}</dd>
                    <br>
                    <dt>Date Updated:</dt> <dd>  {{ date('d.m.Y h:i:s a', strtotime($product->updated_at)) }} </dd>

                </dl>
            </dl>
        </div>
        {{-- <strong>Product: $product->name</strong><br>
        <strong>Category: $product->category->name</strong><br>
        <strong>Price: $product->cost_price * setting('Retail-Price') * setting('1RMB')</strong> --}}
        <div class="col-lg-7" id="cluster_info">
            <div class="text-center">
                {!! QrCode::size(200)->gradient(0, 0, 200, 0, 0, 50,'vertical')->generate("Product: " .$product->manufacturer->name . " " . $product->name. ", Category: " .$product->category->name. " Price:N".number_format($product->cost_price * setting('Retail-Price') * setting('1RMB'), 2)); !!}
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <dl class="dl-horizontal">
                <dt>Remark:</dt>
                <dd>
                    <small><strong>{{ $product->remark }}</strong></small>
                </dd>
            </dl>
        </div>
    </div>
    <div class="row m-t-sm">
        <div class="col-lg-12">
            <div class="panel blank-panel">
                <div class="panel-heading">
                    <div class="panel-options">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-1" data-toggle="tab">Store with Stocks <span class="label label-danger">{{ count($product->stocks)}}</span></a></li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-1">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Store</th>
                                        <th>Quantity Available</th>
                                        <th>Re-order Quantity</th>
                                        <th>Date Created</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->stocks as $item)
                                    <tr>
                                        <td>
                                            {{ $item->store->name}}
                                        </td>
                                        <td>
                                         {{ $item->quantity_in_hand }}
                                     </td>
                                     <td>
                                         {{ $item->re_order_quantity }}
                                     </td>
                                     <td>
                                        {{ $item->created_at->diffForHumans() }}
                                    </td>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<div class="col-lg-3">
{{-- <div class="wrapper wrapper-content project-manager">
<h4>Project description</h4>
<img src="img/zender_logo.png" class="img-responsive">
<p class="small">
There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look
even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing
</p>
<p class="small font-bold">
<span><i class="fa fa-circle text-warning"></i> High priority</span>
</p>
<h5>Project tag</h5>
<ul class="tag-list" style="padding: 0">
<li><a href="#"><i class="fa fa-tag"></i> Zender</a></li>
<li><a href="#"><i class="fa fa-tag"></i> Lorem ipsum</a></li>
<li><a href="#"><i class="fa fa-tag"></i> Passages</a></li>
<li><a href="#"><i class="fa fa-tag"></i> Variations</a></li>
</ul>
<h5>Project files</h5>
<ul class="list-unstyled project-files">
<li><a href="#"><i class="fa fa-file"></i> Project_document.docx</a></li>
<li><a href="#"><i class="fa fa-file-picture-o"></i> Logo_zender_company.jpg</a></li>
<li><a href="#"><i class="fa fa-stack-exchange"></i> Email_from_Alex.mln</a></li>
<li><a href="#"><i class="fa fa-file"></i> Contract_20_11_2014.docx</a></li>
</ul>
<div class="text-center m-t-md">
<a href="#" class="btn btn-xs btn-primary">Add files</a>
<a href="#" class="btn btn-xs btn-primary">Report contact</a>

</div>
</div> --}}
</div>
</div>

@endsection
