<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>

@extends('accounting.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="{{asset('admin/assets/css/datatable.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{asset('admin/assets/css/datatable.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">

<style>
    .table td, .table th,label {
        font-size: 11px;
    }
    div.dt-button-collection {
     background-color: #0275d8;
    }
</style>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Good Receipt List</a></li>
                            <li class="active">Show</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    @if($message = Session::get('destroy'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif($message = Session::get('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card-header">
                        <strong class="card-title"><i class="fa fa-list"></i> Not Verified List</strong>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        @if ($start_date != null || $end_date != null || $vendor != null)
                        <p style="text-align: center; background-color: #11CDEF; color: white;"><strong class="card-title">GR Date:{{ Carbon\Carbon::parse($start_date)->format('d F Y') }} To: {{ Carbon\Carbon::parse($end_date)->format('d F Y') }}&nbsp; || &nbsp;Vendor Name: {{ ($vendor) }}</strong></p>
                        @endif
                        <form action="{{ route('accounting-filternot') }}" class="form-inline" method="GET">
                            <div class="form-group col-md-2">

                            </div>
                            <div class="form-group ">
                              <label for="" >GR Date: &nbsp;</label>
                              <input type="date" class="form-control form-control-sm" name="start_date">
                            </div>
                            <div class="form-group mx-sm-2">
                              <label for="inputPassword2">To: &nbsp;</label>
                              <input type="date" class="form-control form-control-sm" name="end_date">
                            </div>
                            <div class="form-group col-md-2-half">
                                <select class="form-control form-control-sm" name="vendor">
                                    <option value="">-- Choose Vendor Name -- </option>
                                        @foreach ($vendor_name as $vendor_name)
                                            <option value="{{ $vendor_name['vendor_name'] }}">{{ $vendor_name['vendor_name'] }}</option>
                                        @endforeach
                                </select>
                            </div> &nbsp;&nbsp;
                            <div hidden class="form-group col-md-2-half">
                                <select class="form-control form-control-sm status_invoice" name="">
                                    <option value="">-- Choose Sts. Inv. Props. -- </option>
                                    <option value="Verified">Verified</option>
                                    <option value="Not Yet Verified - Draft BA">Not Yet Verified - Draft BA</option>
                                </select>
                            </div> &nbsp;&nbsp;
                            <button class="btn btn-primary" onclick="return confirm('Are you sure?')" type="submit"><i class="fa fa-search"></i></button>
                        </form>
                        <form action="" method="POST">
                            @csrf
                            <table id="list" class="table table-striped" style="font-size: 10px;">
                                <thead>
                                    <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Sts. GR</th>
                                    <th style="text-align: center;">Sts. Inv. Props.</th>
                                    <th style="text-align: center;">Vendor</th>
                                    <th style="text-align: center;">PO</th>
                                    <th style="text-align: center;">GR Number</th>
                                    <th style="text-align: center;">GR Date</th>
                                    <th style="text-align: center;">Part Number</th>
                                    <th style="text-align: center;">Mat. Desc.</th>
                                    <th style="text-align: center;">QTY UOM</th>
                                    <th style="text-align: center;">Curr</th>
                                    <th style="text-align: center;">Unit Price</th>
                                    <th style="text-align: center;">Ref.</th>
                                    <th style="text-align: center;">Del. Note</th>
                                    <th style="text-align: center;">Tax Code</th>
                                </tr>
                                </thead>
                                <tbody style="font-size: 11px;">
                                    @foreach($good_receipts as $good_receipt)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td >Not Yet Verified</td>
                                        <td >{{ $good_receipt->status_invoice }}</td>
                                        <td >{{ $good_receipt->id_vendor }} /{{ $good_receipt->vendor_name}}</td>
                                        <td ><span>{{$good_receipt->no_po}} /{{$good_receipt->po_item}}</span></td>
                                        <td ><span>{{$good_receipt->gr_number}}</span></td>
                                        <td><span>{{ Carbon\Carbon::parse($good_receipt->gr_date)->format('d F Y') }}</span></td>
                                        <td> <span>{{$good_receipt->material_number}}/<br> {{$good_receipt->vendor_part_number}}</span></td>
                                        <td> <span>{{$good_receipt->mat_desc}}</span> <br>({{$good_receipt->valuation_type}})</td>
                                        <td> <span>{{$good_receipt->jumlah}}</span>&nbsp;<span>{{$good_receipt->uom}}</span> </td>
                                        <td> <span>{{$good_receipt->currency}}</span> </td>
                                        <td style="text-align: right">
                                            <span>{{number_format($good_receipt->harga_satuan, 0,",",".")}}</span>
                                        </td>
                                        <td> <span>{{$good_receipt->ref_doc_no}}</span> </td>
                                        <td> <span>{{$good_receipt->delivery_note}}</span> </td>
                                        <td> <span>{{$good_receipt->tax_code}}</span> </td>
                                    </tr>
                                    @endforeach
                                    </select>
                                </tbody>
                            </table>
                            <div class="row mt-2 col-lg-12 col-md-6" >
                                <div class="col-6">
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="card responsive bg-light card-outline-danger text-cen">
                                        <span class="pull-right clickable close-icon text-right" data-effect="fadeOut"><i class="fa fa-times"></i></span>
                                        <div class="card-block text-white">
                                          <blockquote class="card-blockquote text-white">
                                            <p style="font-size: 14px;"><strong>&nbsp; Good receipt Not verified description: </strong></p>
                                            <p style="font-size: 13px;"><strong>&nbsp;  Not verified: good receipt data that has certain conditions and requires verification <br>&nbsp;  by the vendor.
                                            Certain conditions in the GR data that enter the not verified status are <br>&nbsp;  combinations where the data posting date, material number, quantity, vendor id and <br>&nbsp; 
                                                reference are the same data.</strong></p>
                                        </blockquote>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                          </form>
                    </div> <!-- /.table-stats -->
                </div>
            </div>
            </div>
        </div>
    </div>

</div>
</div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>

<footer class="site-footer">
    <div class="footer-inner bg-white">
        <div class="row">
            <div class="col-sm-6">
                <!-- Copyright &copy; 2018 Ela Admin -->
            </div>
            <div class="col-sm-6 text-right">
                Designed by <a href="https://colorlib.com">Colorlib</a>
            </div>
        </div>
    </div>
</footer>

</div><!-- /#right-panel -->

<script type="text/javascript">
    var minDate, maxDate;
    
    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date(data[5]);
    
            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        }
    );
    
    $(document).ready(function() {
    
        // Create date inputs
        minDate = new DateTime($('#min'), {
            format: 'MMMM Do YYYY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'MMMM Do YYYY'
        });
    
        // DataTables initialisation
        var table = $('#list').DataTable({
            dom: "<'row'<'col-md-2 bg-white'l><'col-md-5 bg-white'B><'col-md-5 bg-white'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-6'i><'col-md-6'p>>",
        columnDefs: [
            {
                targets: 1,
                className: 'noVis'
            }
        ],
        buttons: [
            {
                extend: 'colvis',
                columns: ':not(.noVis)'
            }
        ],
            rowReorder: true,
             columnDefs: [
            { orderable: true, className: 'reorder', targets: 1 },
            { orderable: true, className: 'reorder', targets: 5 },
            { orderable: true, className: 'reorder', targets: 6 },
            { orderable: false, targets: '_all' }
                    ],
            lengthMenu: [[10, 25, 50, -1],[10, 25, 50, 'All'],],

        });
    
        // Refilter the table
        $('#min, #max').on('change', function() {
            table.draw();
        });
    
    
    });
    
    function checkAll(box) {
        let checkboxes = document.getElementsByTagName('input');
    
        if (box.checked) { // jika checkbox teratar dipilih maka semua tag input juga dipilih
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
        } else { // jika checkbox teratas tidak dipilih maka semua tag input juga tidak dipilih
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }
    </script>
@endsection