@extends('layouts.master')

@section('content')
<style type="text/css">
    td,
    th,
    tr,
    table {
        border-top: 1px solid black;
        border-collapse: collapse;
    }

    .ticket {
        width: 155px;
        max-width: 155px;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Products Barcode for thermal printer</h2>
        <ol class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a>Products Barcode</a>
            </li>
            <li class="active">
                <strong>All Products Barcode</strong>
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
        <p class="text-center" style="margin-top: 10px" id="print-btn">
            <input class="btn btn-primary" type="button" onclick="printDiv('printableArea')" value="Print page" />
        <div class="ticket" id="printableArea" style="margin: auto;">
            <table>
                @foreach($products as $item)
                <tr>
                   <td>

                       {{ $item->manufacturer->name }} {{ $item->name }} ({{$item->category->name}}) <br>
                       @php
                       echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($item->id, 'C39', 1.4, 100) . '" alt="barcode"   />';
                       @endphp
                       <br><br>
                   </td>
               </tr>
               @endforeach
           </table>



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
