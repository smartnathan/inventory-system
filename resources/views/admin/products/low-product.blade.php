@extends('layouts.master')
@section('content')
<div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12 animated fadeInRight">
            <div class="mail-box-header">

                <form method="get" action="#" class="pull-right mail-search">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" name="search" placeholder="Search email">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
                <h2>
                Low Products(s) <strong>({{(count($low_products) > 0) ? count($low_products) : '0'}})</strong>
                </h2>
            </div>
                <div class="mail-box">

                <table class="table table-hover table-mail">
                <tbody>
                    <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Product Code</th>
                        <th>Store</th>
                        <th>Quantity Available</th>
                        <th>Date Updated</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($low_products as $item)
                <tr>
                    <td class="check-mail">
                        <input type="checkbox" class="i-checks">
                    </td>
                    <td class="mail-subject">
                        {{ $item->product->manufacturer->name ?? "No valid product"}} {{ $item->product->name ?? "No valid model"}}
                    </td>
                    <td class="mail-subject">
                        {{ $item->product->code ?? 'No valid Product Code'}}
                    </td>
                    <td class="mail-subject">
                        {{ $item->store->name ?? 'No Linked Store' }}
                    </td>
                    <td class="mail-check">
                        {{ $item->quantity_in_hand }}
                    </td>
                    <td class="mail-date">
                    {{ $item->updated_at->diffForHumans() }}
                    </td>
                    <td>
                        <span class="label label-danger">Low</span>
                    </td>
                    <td>
                        <a target="_blank" href="{{ url('admin/purchase-order-headers/create') }}?product={{ $item->product_id }}" class="btn btn-primary btn-rounded">Re-Stock</a>
                    </td>
                </tr>
                    @endforeach
                </tbody>
                </table>


                </div>
            </div>
        </div>
        </div>
@endsection
