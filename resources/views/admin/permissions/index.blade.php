@extends('layouts.master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Permission</h2>
        <ol class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a>Permission</a>
            </li>
            <li class="active">
                <strong>All Permission</strong>
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
                <a href="{{ url('/admin/permissions/create') }}" class="btn btn-success btn-sm" title="Add New Permissions">
                    <i class="fa fa-laptop" aria-hidden="true"></i>
                    <span class="bold"> Add Permissions</span>
                </a>

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
                        {!! Form::open(['method' => 'GET', 'url' => '/admin/permissions', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="search" placeholder="Search" value="{{ request('search') }}">
                            <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary"> Go!</button>
                            </span>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th><th>Name</th><th>Label</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $item)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $item->name }}</td><td>{{ $item->label }}</td>
                            <td>
                                {{-- <a href="{{ url('/admin/permissions/' . $item->id) }}" title="View Permission"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a> --}}
                                <a href="{{ url('/admin/permissions/' . $item->id . '/edit') }}" title="Edit Permission"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'url' => ['/admin/permissions', $item->id],
                                    'style' => 'display:inline'
                                ]) !!}
                                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                            'type' => 'submit',
                                            'class' => 'btn btn-danger btn-sm',
                                            'title' => 'Delete Permission',
                                            'onclick'=>'return confirm("Confirm delete?")'
                                    )) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $permissions->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>

        </div>
    </div>
</div>
</div>




@endsection
