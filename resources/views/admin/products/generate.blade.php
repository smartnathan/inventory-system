@extends('layouts.master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Products</h2>
        <ol class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a>Products</a>
            </li>
            <li class="active">
                <strong>All Products</strong>
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
                <a href="{{ url('/admin/products') }}" class="btn btn-success btn-sm" title="Back">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    <span class="bold"> Back</span>
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
        @php
        $row = round(count($products)/2);
        $prodInit = 0;
        @endphp
        <div class="ibox-content" id="printableArea">
            <table class="table table-bordered">
                @for ($i = 1; $i <= $row; $i++)
                <tr>
                   @for ($j = 1; $j <= 2; $j++)
                   <td>
                       @if ($products[$prodInit])
                       <p>{{ $products[$prodInit]->manufacturer->name }} {{ $products[$prodInit]->name }} ({{$products[$prodInit]->category->name}})</p>
                       @php
    echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($products[$prodInit]->code, 'C39', 1) . '" alt="barcode"   />';
    @endphp
                       @else
                       No Product found
                       @endif
                   </td>
                   @php
                   $prodInit++;
                   @endphp
                   @endfor
                </tr>
                @endfor
            </table>
            
            <p class="text-center" style="margin-top: 10px" id="print-btn">
                            <input class="btn btn-primary" type="button" onclick="printDiv('printableArea')" value="Print page" />

                        </p>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    function printDiv(divName) {
      document.getElementById('print-btn').style.display="none";
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

@endsection
