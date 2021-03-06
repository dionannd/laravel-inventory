@extends('layouts.pdf.master')

@section('content')

    <!-- Invoice template -->
    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <img src="{{ asset('images/logo_demo.png') }}" class="mb-3 mt-2" alt="" style="width: 120px;">
                        <ul class="list list-unstyled mb-0">
                            <li>{{$invoicePurchase->supplier->address}}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <div class="text-sm-right">
                        <h4 class="text-primary mb-2 mt-md-2">Invoice #{{$invoicePurchase->no_invoice}}</h4>
                            <ul class="list list-unstyled mb-0">
                                <li>Date: <span class="font-weight-semibold">{{$invoicePurchase->created_at->format('d F Y')}}</span></li>
                                <li>Due date: <span class="font-weight-semibold">{{$invoicePurchase->created_at->format('d F Y')}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-md-flex flex-md-wrap">
                <div class="mb-4 mb-md-2">
                    <span class="text-muted">Invoice To:</span>
                    <ul class="list list-unstyled mb-0">
                        <li><h5 class="my-2">{{$invoicePurchase->supplier->supplier_name}}</h5></li>
                        <li><span class="font-weight-semibold">{{$invoicePurchase->supplier->legal_name}}</span></li>
                        <li>{{$invoicePurchase->supplier->address}}</li>
                        <li>{{$invoicePurchase->supplier->phone}}</li>
                        <li><a href="#">{{$invoicePurchase->supplier->email}}</a></li>
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
                            <li><h5 class="font-weight-semibold my-2">Rp. {{$invoicePurchase->total}}</h5></li>
                            <li><span class="font-weight-semibold">{{$invoicePurchase->finance->account_name}}</span></li>
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
                            <h6 class="mb-0">{{$invoicePurchase->product->name_product}}</h6>
                            <span class="text-muted">{{$invoicePurchase->product->category->name_category}}</span>
                        </td>
                        <td>{{$invoicePurchase->qty}}</td>
                        <td>Rp. {{$invoicePurchase->price}}</td>
                        <td><span class="font-weight-semibold">Rp. {{$invoicePurchase->qty*$invoicePurchase->price}}</span></td>
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
                    <h2 class="badge badge-success" >{{$invoicePurchase->status}}</h2>

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
                                    <td class="text-right">Rp. {{$invoicePurchase->qty*$invoicePurchase->price}}</td>
                                </tr>
                                <tr>
                                    <th>Shipping Cost:</th>
                                    <td class="text-right">Rp. {{$invoicePurchase->cost}}</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td class="text-right text-primary"><h5 class="font-weight-semibold">Rp. {{$invoicePurchase->total}}</h5></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <span class="text-muted">Thank you for buy My Product. This invoice can be paid via Bank transfer, Skrill or Payoneer. Payment is due within 30 days from the date of delivery. Late payment is possible, but with with a fee of 10% per month. </span>
        </div>
    </div>
    <!-- /invoice template -->
@endsection
