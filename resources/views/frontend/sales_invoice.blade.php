@extends('layouts.pages.master')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Invoice Sales</h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

    </div>

    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <a href="{{ route('sales.index') }}" class="breadcrumb-item">Sales</a>
                <span class="breadcrumb-item active">Invoice</span>
            </div>

            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">

    <!-- Invoice template -->
    <div class="card">
        <div class="card-header bg-transparent header-elements-inline">
            <h6 class="card-title">Sales Invoice</h6>
            <div class="header-elements">
                <button type="button" class="btn btn-light btn-sm ml-3"><i class="icon-printer mr-2"></i> Print</button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-4">
                        <img src="{{ asset('images/logo_demo.png') }}" class="mb-3 mt-2" alt="" style="width: 120px;">
                        <ul class="list list-unstyled mb-0">
                            <li>{{$invoiceSales->customer->address}}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-4">
                        <div class="text-sm-right">
                        <h4 class="text-primary mb-2 mt-md-2">Invoice #{{$invoiceSales->no_invoice}}</h4>
                            <ul class="list list-unstyled mb-0">
                                <li>Date: <span class="font-weight-semibold">{{$invoiceSales->created_at->format('d F Y')}}</span></li>
                                <li>Due date: <span class="font-weight-semibold">{{$invoiceSales->created_at->format('d F Y')}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-md-flex flex-md-wrap">
                <div class="mb-4 mb-md-2">
                    <span class="text-muted">Invoice To:</span>
                    <ul class="list list-unstyled mb-0">
                        <li><h5 class="my-2">{{$invoiceSales->customer->first_name.' '.$invoiceSales->customer->last_name}}</h5></li>
                        <li><span class="font-weight-semibold">{{$invoiceSales->customer->legal_name}}</span></li>
                        <li>{{$invoiceSales->customer->address}}</li>
                        <li>{{$invoiceSales->customer->phone}}</li>
                        <li><a href="#">{{$invoiceSales->customer->email}}</a></li>
                    </ul>
                </div>

                <div class="mb-2 ml-auto">
                    <span class="text-muted">Payment Details:</span>
                    <div class="d-flex flex-wrap wmin-md-400">
                        <ul class="list list-unstyled mb-0">
                            <li><h5 class="my-2">Total Due:</h5></li>
                            <li>Bank name:</li>
                            {{-- <li>Country:</li>
                            <li>City:</li>
                            <li>Address:</li>
                            <li>IBAN:</li>
                            <li>SWIFT code:</li> --}}
                        </ul>

                        <ul class="list list-unstyled text-right mb-0 ml-auto">
                            <li><h5 class="font-weight-semibold my-2">Rp. {{$invoiceSales->total}}</h5></li>
                            <li><span class="font-weight-semibold">{{$invoiceSales->finance->account_name}}</span></li>
                            {{-- <li>United Kingdom</li>
                            <li>London E1 8BF</li>
                            <li>3 Goodman Street</li>
                            <li><span class="font-weight-semibold">KFH37784028476740</span></li>
                            <li><span class="font-weight-semibold">BPT4E</span></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-lg">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>SubTotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h6 class="mb-0">{{$invoiceSales->product->name_product}}</h6>
                            <span class="text-muted">{{$invoiceSales->product->category->name_category}}</span>
                        </td>
                        <td>{{$invoiceSales->qty}}</td>
                        <td>Rp. {{$invoiceSales->price}}</td>
                        <td><span class="font-weight-semibold">Rp. {{$invoiceSales->qty*$invoiceSales->price}}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-body">
            <div class="d-md-flex flex-md-wrap">
                <div class="pt-2 mb-3">
                    <h6 class="mb-3">Authorized person</h6>
                    <div class="mb-3">
                        <br>
                        <img src="{{ asset('images/signature.png') }}" width="150" alt="">
                    </div>

                    {{-- <ul class="list-unstyled text-muted">
                        <li>Eugene Kopyov</li>
                        <li>2269 Elba Lane</li>
                        <li>Paris, France</li>
                        <li>888-555-2311</li>
                    </ul> --}}
                </div>

                <div class="pt-2 mb-3 wmin-md-400 ml-auto">
                    <h6 class="mb-3">Total due</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>SubTotal:</th>
                                    <td class="text-right">Rp. {{$invoiceSales->qty*$invoiceSales->price}}</td>
                                </tr>
                                <tr>
                                    <th>Shipping Cost:</th>
                                    <td class="text-right">Rp. {{$invoiceSales->cost}}</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td class="text-right text-primary"><h5 class="font-weight-semibold">Rp. {{$invoiceSales->total}}</h5></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-primary btn-labeled btn-labeled-left"><b><i class="icon-paperplane"></i></b> Export to .pdf</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <span class="text-muted">Thank you for buy My Product. This invoice can be paid via Bank transfer, Skrill or Payoneer. Payment is due within 30 days from the date of delivery. Late payment is possible, but with with a fee of 10% per month. </span>
        </div>
    </div>
    <!-- /invoice template -->

</div>
<!-- /content area -->
@endsection
