@extends('layouts.pages.master')

@section('title', 'Kerugian')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light border-bottom-1 border-bottom-primary">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-left2 mr-2"></i> <span class="font-weight-semibold">Kerugian</span></h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <span class="breadcrumb-item active">Kerugian</span>
            </div>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- Content area -->
<div class="content">
    <div class="card">
        <div class="card-header bg-primary text-white header-elements-inline">
            <h6 class="card-title"><span class="font-weight-semibold">Data Kerugian</span></h6>
            <a href="javascript:void(0)" class="btn btn-success" id="create">Tambah <i class="icon-file-plus2"></i></a>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Nama Barang</th>
                        <th style="width:50px;">Qty</th>
                        <th>Harga Pembelian</th>
                        <th>Tanggal Pembelian</th>
                        <th>Total</th>
                        <th>Deskripsi</th>
                        <th style="width:10px;">#</th>
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
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <select name="product_id" id="product_id" class="form-control select-search" data-fouc>
                        	<option value="">Pilih</option>
                        	<optgroup label="Pilih Barang">
	                            @foreach ($purchase as $item)
	                            <option value="{{$item->id}}">{{$item->product->name}}</option>
	                            @endforeach
                        	</optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" id="qty" name="qty" placeholder="Masukan Jumlah Barang" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Pembelian</label>
                        <input type="number" id="price" name="price" value="0" placeholder="Pilih Barang" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pembelian</label>
                        <input type="text" id="date" name="date" placeholder="Pilih Barang" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="desc" id="desc" cols="3" rows="3" class="form-control"></textarea>
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
		// DataTable
	    var table = $('#table').DataTable({
	        serverSide: true,
	        ajax: '{{route('loss.index')}}',
	        columns: [
	            {data: "id",
	                render: function (data, type, row, meta) {
	                    return meta.row + meta.settings._iDisplayStart +1;
	                }
	            },
	            {data: "product.name"},
	            {data: "qty"},
	            {data: "price"},
	            {data: "date_purchase"},
	            {data: "total"},
	            {data: "desc"},
	            {data: "action"}
	        ]
	    });
	     // Add Modal
        $('#btn-add').click(function(){
            $('#form').trigger('reset');
            $('#modal_header').html("Tambah Kerugian");
            $('#modal').modal('show');
        });
        $('#modal').on('hidden.bs.modal', function(){
            $(this).find('form')[0].reset();
            $('#error-qty').html('');
            $('#error-price').html('');
            $('#error-total').html('');
        });
        // Function Add or Edit
        $('#btn-save').on('click', function(){
            var form = $('#form').serialize();
            $.ajax({
                url: '{{route('loss.store')}}',
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
                        url: 'loss/delete'+'/'+ id,
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
                        text: 'Data tersimpan.',
                        type: 'error',
                        progressBar: false,
                        timeout: 2000,
                        closeWith: ['button']
                    }).show();
                }
            })
        });
        // Get data
		$('#product_id').on('change', function(){
	        var id = $(this).find(':selected').val();
	        $.ajax({
	            url: '{{ route('loss.getdata')}}',
	            type: 'POST',
	            data: {'id': id},
	            dataType: 'json',
	            success: function(response){
	                console.log(response);
                    $('#price').val(response.data.price);
	                $('#date').val(response.data.created_at);
	            },
                error: function(response){
                    console.log(response)
                }
	        });
	    });
	    /*-------- TOTAL PRICE ---------- */
        var total = 0;
        $('#qty').on('keyup',function(){
            var price = $('#price').val();
            var qty = $(this).val();
            total = price * qty;
            $('#total').val(total);
        })
        /* ------------------------------ */
	})	
</script>
@endpush