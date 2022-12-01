@extends('vendor.layouts.sidebar')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">
<style>
    .table td, .table th {
        font-size: 11px;
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
                            <li><a href="#">Dispute Good Receipt List</a></li>
                            <li class="active">Create</li>
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
            <div class="col">
                <div class="card  shadow h-100">
                    <div class="card-header">
                        <strong class="card-header">Dispute Good Receipt</strong>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off" action="{{ route('dispute_datagr') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @foreach ($good_receipts as $good)
                            <input type="hidden" name="id[]" value="{{$good->id_gr}}">
                            @endforeach
                            {{-- <b class="mb-4">
                                    {{ $good->id }}
                            </b> --}}
                            {{-- <div class="form-group">
                                        <label class="form-control-label" for="id">GR Number</label>
                                        <input type="number" class="form-control @error('id') is-invalid @enderror" name="id" placeholder="Masukkan Tanggal ..." value="{{ $good->id }}">
                            @error('id')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div> --}}
                    {{-- <div class="form-group">
                        <label class="form-control-label" for="Status[]">Status</label> <br>
                        <select name="status[]" class="form-control">
                            <option value="Verified" {{ $good->Status == "Verified" ? 'selected' : '' }}>
                                Verified</option>
                            <option value="Dispute" {{ $good->Status == "Dispute" ? 'selected' : '' }}>Dispute</option>    
                        </select>
                    </div> --}}
                    <div class="form-group">
                        <label class="form-control-label" for="alasan_disp">Dispute Identification</label>
                        <textarea name="alasan_disp" class="form-control" placeholder="Mohon masukan alasan dispute invoice" id="" cols="20" rows="5"></textarea>
                        @error('alasan_disp')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    {{-- <div class="form-group">
                        <label class="form-control-label" for="no_po[]">PO Number</label>
                        <input type="number" class="form-control @error('no_po[]') is-invalid @enderror" name="no_po[]"
                            placeholder="Masukkan Tanggal ..." value="{{ $good->no_po }}">
                        @error('no_po[]')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="po_item[]">PO Item</label>
                        <input type="number" class="form-control @error('po_item[]') is-invalid @enderror"
                            name="po_item[]" placeholder="Masukkan Tanggal ..." value="{{ $good->po_item }}">
                        @error('po_item[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="GR_Date[]">GR Slip Date</label>
                        <input type="date" class="form-control @error('GR_Date[]') is-invalid @enderror"
                            name="GR_Date[]" placeholder="Masukkan Tanggal ..." value="{{ $good->GR_Date }}">
                        @error('GR_Date[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="Delivery_Note[]">Delivery Note</label>
                        <input type="text" class="form-control @error('Delivery_Note[]') is-invalid @enderror"
                            name="Delivery_Note[]" placeholder="Masukkan Tanggal ..." value="{{ $good->Delivery_Note }}">
                        @error('Delivery_Note[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="Material_Number[]">Material Number</label>
                        <input type="text" class="form-control @error('Material_Number[]') is-invalid @enderror"
                            name="Material_Number[]" placeholder="Masukkan Tanggal ..."
                            value="{{ $good->Material_Number }}">
                        @error('Material_Number[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="Tax_Code[]">Tax Code</label>
                        <input type="text" class="form-control @error('Tax_Code[]') is-invalid @enderror"
                            name="Tax_Code[]" placeholder="Masukkan Tanggal ..." value="{{ $good->Tax_Code }}">
                        @error('Tax_Code[]')<span
                            class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="Status[]">Status</label> <br>
                        <select name="status[]" class="form-control">
                            <option value="Not Verified" {{ $good->Status == "Not Verified" ? 'selected' : '' }}>Not
                                Verified</option>
                            <option value="Verified" {{ $good->Status == "Verified" ? 'selected' : '' }}>Verified
                            </option>
                            <option value="Reject" {{ $good->Status == "Reject" ? 'selected' : '' }}>Reject</option>
                        </select>
                    </div> --}}
                    <button type="submit" name="action" value="Dispute" onclick="return confirm('Are you sure?')" class="btn btn-warning" id="simpan">Dispute</button>
                    <a href="{{url('vendor/purchaseorder')}}" onclick="return confirm('Are you sure?')" class="btn btn-danger">Return</a>
                    </form>
                    <br>
                    <strong class="card-header">Good Receipt Data to be Disputed</strong>
                    <table id="list" class="table table-stats order-table ov-h">
                        <thead>
                            <tr>
                                <th></th>
                                <th>GR Number</th>
                                <th>No PO</th>
                                <th>PO Item</th>
                                <th>GR Slip Date</th>
                                <th>Material Number</th>
                                <!-- <th class="text-center">Reference</th> -->
                                <!-- <th class="text-center">Vendor Part Number</th>
                                        <th class="text-center">Item Description</th>
                                        <th class="text-center">UoM</th>
                                        <th class="text-center">Currency</th>
                                        <th class="text-center">Harga Satuan</th>
                                        <th class="text-center">Jumlah</th> -->
                                <!-- <th class="text-center">Jumlah Harga</th> -->
                                <th>Tax Code</th>
                                <!-- <th class="text-center">Valuation Type</th> -->
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($good_receipts as $good_receipt)
                            <tr>
                            <td><input type="hidden" name="ids[]" value="{{$good_receipt->id}}"></td>      
                            
                            <td><span class="name">{{$good_receipt->gr_number}}</span> </td>
                            <td> <span class="">{{$good_receipt->no_po}}</span> </td>
                            <td> <span class="">{{$good_receipt->po_item}}</span> </td>
                            <td><span>{{ Carbon\Carbon::parse($good_receipt->gr_date)->format('d F Y') }}</span></td>
                            <td> <span class="">{{$good_receipt->material_number}}</span>
                            </td>
                            <!-- <td class="text-center"> <span class="">{{$good_receipt->Ref_Doc_No}}</span> </td> -->
                            <!-- <td class="text-center"> <span class="">{{$good_receipt->Vendor_Part_Number}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->Mat_Desc}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->UOM}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->Currency}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->harga_satuan}}</span> </td>
                                        <td class="text-center"> <span class="">{{$good_receipt->jumlah}}</span> </td> -->
                            <!-- <td class="text-center"> <span class="">{{$good_receipt->jumlah_harga}}</span> </td> -->
                            <td> <span class="">{{$good_receipt->tax_code}}</span> </td>
                            <!-- <td class="text-center"> <span class=""></span> </td> -->
                            <td>{{ $good_receipt->status }}</td>
                            </tr>
                            @endforeach
                        </select>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>

</div><!-- /#right-panel -->
@endsection