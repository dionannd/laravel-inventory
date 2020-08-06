@extends('layouts.pages.master')

@section('title', 'Pembelian Produk')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light border-bottom-1 border-bottom-primary">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-left2 mr-2"></i> <span class="font-weight-semibold">Pembelian Produk</span></h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <span class="breadcrumb-item active">Pembelian</span>
            </div>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- Content area -->
<div class="content">
    <div class="card">
        <div class="card-header bg-primary text-whit header-elements-inline">
            <h6 class="card-title"><span class="font-weight-semibold">Data Pembelian</span></h6>
            <a href="javascript:void(0)" class="btn btn-success" id="create">Tambah <i class="icon-file-plus2"></i></a>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Barang</th>
                        <th>Pemasok</th>
                        <th>Pembayaran</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>SubTotal</th>
                        <th>Biaya</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="140px">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- modal -->
<div id="modal" class="modal fade" data-backdrop="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modal-header"></h5>
            </div>
            <form id="form" name="form" class="form-horizontal">
                @csrf
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor Invoice</label>
                        <input type="text" id="invoice" name="invoice" class="form-control" value="{{$invoice}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Barang</label>
                        <select name="product_id" id="product_id" class="form-control select-search" data-fouc>
                            <option value="">Pilih</option>
                            <optgroup label="Pilih Barang">
                                @foreach ($product as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        <a href="{{ route('product.index') }}">Tambah produk</a>
                    </div>
                    <div class="form-group">
                        <label>Pembayaran</label>
                        <select name="finance_id" id="finance_id" class="form-control select-search" data-fouc>
                            <option value="">Pilih</option>
                            <optgroup label="Pilih Pembayaran">
                                @foreach ($filter as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Pemasok</label>
                        <select name="supplier_id" id="supplier_id" class="form-control select-search" data-fouc>
                            <option value="">Pilih</option>
                            <optgroup label="Nama Pemasok">
                                @foreach ($supplier as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        <a href="{{ route('supplier.index') }}">Tambah pemasok</a>
                    </div>
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="number" id="qty" name="qty" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" id="price" name="price" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>SubTotal</label>
                        <input type="number" id="subtotal" name="subtotal" value="0" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Biaya Kirim</label>
                        <input type="number" id="cost" name="cost" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Total</label>
                        <input type="number" id="total" name="total" value="0" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-primary" id="save" value="create">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        // Function DataTable
        var table = $('#table').DataTable({
            serverSide: true,
            ajax: '{{route('purchase.index')}}',
            columns: [
                {data: 'invoice', name: 'invoice'},
                {data: 'product.name', name: 'product.name'},
                {data: 'supplier.name', name: 'supplier.name'},
                {data: 'finance.name', name: 'finance.name'},
                {data: 'qty', name: 'qty'},
                {data: 'price', name: 'price'},
                {data: 'subtotal', name: 'subtotal'},
                {data: 'cost', name: 'cost'},
                {data: 'total', name: 'total'},
                {data: 'status'},
                {data: 'action', rderable: false, searchable: false}
            ]
        });
        // Function Click Create
        $('#create').click(function(){
            $('#save').val('create');
            $('#id').val('');
            $('#form').trigger('reset');
            $('#modal-header').html('Tambah Pembelian');
            $('#modal').modal('show');
        });
        // Function Add or Edit
        $('#save').on('click', function(e){
            e.preventDefault();
            $(this).html('Menyimpan...');
            $.ajax({
                data: $('#form').serialize(),
                url: '{{route('purchase.store')}}',
                type: 'POST',
                dataType: 'JSON',
                success: function(data){
                    $('.submit').html('Simpan');
                    $('#form').trigger('reset');
                    $('#modal').modal('toggle');
                    table.ajax.reload();
                    swal({
                        title: 'Berhasil!',
                        text: data.success,
                        type: 'success',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-primary'
                    });
                },
                error: function(data){
                    console.log('Error', data);
                    new Noty({
                        theme: ' alert alert-warning alert-styled-left p-0',
                        text: data.responseJSON.error,
                        type: 'error',
                        progressBar: false,
                        timeout: 2000,
                        closeWith: ['button']
                    }).show();
                }
            });
        });
        // Function Aprrove
        $('body').on('click', '.approve', function(){
            var id = $(this).data('id');
            swal({
                title: "Apa kau yakin?",
                text: "Ingin Approve data ini!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Iya, lanjut!',
                cancelButtonText: 'Tidak, kembali',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '/purchase/approve'+'/'+ id,
                        type: 'GET',
                        success: function(data){
                            new Noty({
                                theme: ' alert alert-success alert-styled-left p-0',
                                text: 'Data berhasil di Approve!',
                                type: 'success',
                                progressBar: false,
                                timeout: 2000,
                                closeWith: ['button']
                            }).show();
                        },
                        error: function(data){
                            console.log('Error', data);
                            new Noty({
                                theme: ' alert alert-danger alert-styled-left p-0',
                                text: data.responseJSON.error,
                                type: 'error',
                                progressBar: false,
                                timeout: 2000,
                                closeWith: ['button']
                            }).show();
                        }
                    })
                } else {
                    new Noty({
                        theme: ' alert alert-warning alert-styled-left p-0',
                        text: 'Approve dibatalkan!',
                        type: 'warning',
                        progressBar: false,
                        timeout: 2000,
                        closeWith: ['button']
                    }).show();
                }
            })
        });
        // Delete
        $('body').on('click', '.delete', function(){
            var id = $(this).data('id');
            swal({
                title: "Apa kau yakin?",
                text: "Ingin menghapus data ini!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Iya, hapus!',
                cancelButtonText: 'Tidak, kembali',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'purchase/delete'+'/'+ id,
                        type: "GET",
                        success: function(data){
                            new Noty({
                                theme: ' alert alert-success alert-styled-left p-0',
                                text: data.success,
                                type: 'success',
                                progressBar: false,
                                timeout: 2000,
                                closeWith: ['button']
                            }).show();
                            table.ajax.reload()
                        },
                        error: function(data){
                            console.log('Error', data);
                            new Noty({
                                theme: ' alert alert-danger alert-styled-left p-0',
                                text: data.error,
                                type: 'error',
                                progressBar: false,
                                timeout: 2000,
                                closeWith: ['button']
                            }).show();
                        }
                    })
                } else {
                    new Noty({
                        theme: ' alert alert-info alert-styled-left p-0',
                        text: 'Data tersimpan.',
                        type: 'error',
                        progressBar: false,
                        timeout: 2000,
                        closeWith: ['button']
                    }).show();
                }
            })
        });
        /*-------- TOTAL PRICE ---------- */
        $('#price').on('keyup', function(){
            var qty = $('#qty').val();
            var price = $(this).val();
            subtotal = qty * price;
            $('#subtotal').val(subtotal);
            $('#total').val(subtotal);
        });
        var total = 0;
        $('#cost').on('keyup', function(){
            var subtotal = $('#subtotal').val();
            var cost = $(this).val();
            total = parseInt(subtotal) + parseInt(cost);
            if(total){
                $('#total').val(total);
            } else {
                $('#total').val(subtotal);
            }
        })
        /* ------------------------------ */
    });
</script>
@endpush