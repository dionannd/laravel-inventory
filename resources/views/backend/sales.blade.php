@extends('layouts.pages.master')

@section('title', 'Penjualan Produk')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-left2 mr-2"></i> <span class="font-weight-semibold">Penjualan Produk</span></h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <span class="breadcrumb-item active">Penjualan</span>
            </div>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- /page header -->
<!-- Content area -->
<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Data Penjualan</h5>
            <button id="btn-add" name="btn-add" class="btn btn-alt-secondary">Tambah <i class="icon-file-plus2"></i></button>
        </div>
        <table class="table table-bordered table-striped table-hover datatable-colvis-state" id="table">
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Pelanggan</th>
                    <th>Pemasukan</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Biaya</th>
                    <th>Total</th>
                    <th style="width:10px;">#</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- /Content area -->
<!-- modal -->
<div id="modal" class="modal fade" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_header"></h5>
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
                        <label>Nama Pelanggan</label>
                        <select name="customer_id" id="customer_id" class="form-control select-search" data-fouc>
                            <option value="">Pilih</option>
                            <optgroup label="Pilih Pelanggan">
                                @foreach ($customer as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        <a href="{{ route('customer.index') }}">Tambah pelanggan</a>
                    </div>
                    <div class="form-group">
                        <label>Pemasukan</label>
                        <select name="finance_id" id="finance_id" class="form-control select-search" data-fouc>
                            <option value="">Pilih</option>
                            <optgroup label="Pilih Pemasukan">
                                @foreach ($finance as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <select name="product_id" id="product_id" class="form-control select-search" data-fouc>
                            <option value="">Pilih</option>
                            <optgroup label="Pilih Barang">
                                @foreach ($product as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        <a href="{{route('product.index')}}">Tambah produk</a>
                    </div>
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="number" id="qty" name="qty" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" id="price" name="price" placeholder="Pilih Barang" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="desc" id="desc" cols="3" rows="3" class="form-control"></textarea>
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
                    <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn bg-primary submit" id="btn-save" value="add">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /modal -->
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        // DataTable
        var table = $('#table').DataTable({
            destroy: true,
            serverSide: true,
            ajax: '{{route('sales.data')}}',
            columns: [
                {data: "invoice"},
                {data: "customer.name"},
                {data: "finance.name"},
                {data: "product.name"},
                {data: "qty"},
                {data: "price"},
                {data: "cost"},
                {data: "total"},
                {data: "action"}
            ]
        });
        // Add Modal
        $('#btn-add').click(function(){
            $('#form').trigger('reset');
            $('#modal_header').html("Tambah Penjualan");
            $('#modal').modal('show');
        });
        // Close Modal
        $('#modal').on('hidden.bs.modal', function(){
            $(this).find('form')[0].reset();
            $('#error-no').html('');
            $('#error-supplier').html('');
            $('#error-product').html('');
            $('#error-qty').html('');
            $('#error-price').html('');
            $('#error-subtotal').html('');
            $('#error-cost').html('');
            $('#error-total').html('');
        });
        // Function Add or Edit
        $('#btn-save').on('click', function(){
            var form = $('#form').serialize();
            $.ajax({
                url: '{{route('sales.store')}}',
                data: form,
                method: 'post',
                dataType: 'json',
                beforeSend: function() {
                    $('.submit').html('Tunggu sebentar...');
                },
                success: function(response){
                    $('.submit').html('Simpan');
                    $('#form').trigger('reset');
                    $('#modal').modal('toggle');
                    swal({
                        title: 'Berhasil!',
                        text: response.success,
                        type: 'success',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-primary'
                    });
                    table.ajax.reload()
                },
                error: function(response){
                    $('.submit').html('Simpan');
                    new Noty({
                        theme: ' alert alert-warning alert-styled-left p-0',
                        text: response.responseJSON.error,
                        type: 'error',
                        progressBar: false,
                        timeout: 2000,
                        closeWith: ['button']
                    }).show();
                }
            });
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
                        url: 'sales/delete'+'/'+ id,
                        type: "GET",
                        success: function(response){
                            new Noty({
                                theme: ' alert alert-success alert-styled-left p-0',
                                text: response.success,
                                type: 'success',
                                progressBar: false,
                                timeout: 2000,
                                closeWith: ['button']
                            }).show();
                            table.ajax.reload()
                        },
                        error: function(response){
                            swal("Error!", response.error, "danger");
                        }
                    })
                } else {
                    new Noty({
                        theme: ' alert alert-info alert-styled-left p-0',
                        text: 'Data pembelian tersimpan.',
                        type: 'error',
                        progressBar: false,
                        timeout: 2000,
                        closeWith: ['button']
                    }).show();
                }
            })
        });
        // Get price from product
        $('#product_id').on('change', function(){
            var id = $(this).find(':selected').val();
            $.ajax({
                url: '{{ route('sales.price')}}',
                type: 'POST',
                data: {'id': id},
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    $('#price').val(response.data.price);
                    $('#total').val(response.data.price);
                },
            });
        });
        /*-------- SUB TOTAL PRICE ---------- */
        var total = 0;
        $('#qty').on('keyup',function(){
            var price = $('#price').val();
            var qty = $(this).val();
            total = price * qty;
            $('#total').val(total);
        })
        $('#cost').on('keyup', function(){
            var cost = $(this).val();
            var subtotal = parseInt(cost) + parseInt(total);
            if (subtotal) {
                $('#total').val(subtotal);
            } else {
                $('#total').val(total);
            }
        });
        /* ------------------------------ */
    });
</script>
@endpush