@extends('layouts.pages.master')

@section('title', 'Kerugian')

@section('content')
<!-- HEADER -->
<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>
    <ol class="breadcrumb">
        <li>Home</li><li>Master Keuangan</li><li>Kerugian</li>
    </ol>
</div>
<!-- END HEADER -->			

<!-- MAIN CONTENT -->
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-truck fa-fw "></i> 
                    Master Keuangan
                <span>>  
                    Kerugian
                </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <a href="javascript:void(0);" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i> Import / Export</a>
                </li>
                <li class="sparks-info">
                    <a href="javascript:void(0);" class="btn btn-primary btn-flat" id="create"><i class="fa fa-plus"></i> Tambah Kerugian</a>
                </li>
            </ul>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-xs-12 xol-sm-12 col-md-12 col-lg-12">
                <table id="table" class="table table-striped table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="30px">NO</th>
                            <th><span class="label label-primary">INVOICE</span> NAMA BARANG</th>
                            <th>TGL PEMBELIAN</th>
                            <th width="50px">QTY</th>
                            <th>DESKRIPSI</th>
                            <th width="50px">STATUS</th>
                            <th width="70px" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </article>
        </div>
    </section>
</div>
<!-- /Content area -->

<!-- Modal -->
<div class="modal fade" id="modal" data-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="modal-header"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form" name="form" class="form">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="invoice">No Invoice:*</label>
                                        <select name="invoice" id="invoice" class="select2" data-fouc>
                                            <option value="">Pilih</option>
                                            <optgroup label="Pilih Barang">
                                                @foreach ($purchase as $item)
                                                <option value="{{$item->id}}">{{$item->invoice}} <span class="text-muted">({{ $item->product->name }})</span></option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="qty">Jumlah Rugi:*</label>
                                        <input type="number" id="qty" name="qty" placeholder="Masukan Jumlah Barang" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="price">Harga Pembelian</label>
                                        <input type="number" id="price" name="price" value="" placeholder="Pilih Invoice" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="purchase_qty">Qty:</label>
                                        <input type="number" id="purchase_qty" value="" placeholder="Pilih Invoice" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="product_id">Nama Barang:*</label>
                                        <input type="text" id="product_id" name="product_id" placeholder="Pilih Invoice" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">Tanggal Pembelian:*</label>
                                        <input type="text" id="date" name="date" placeholder="Pilih Invoice" value="" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="desc">Deskripsi:*</label>
                                        <textarea name="desc" id="desc" cols="3" rows="3" class="form-control" placeholder="Masukan keterangan kerugian"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total">Total:</label>
                                        <input type="text" id="total" name="total" value="0" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-muted mr-auto">Keterangan: Tanda <code>(*)</code> wajib diisi!</span>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="save" value="create">Simpan <i class="fa fa-send"></i></button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END CONTENT -->
@endsection

@push('scripts')
<script>
	$(document).ready(function(){
		// DataTable
	    var table = $('#table').DataTable({
	        serverSide: true,
            responsive: true,
            autoWidth: true,
	        ajax: '{{route('loss.index')}}',
	        columns: [
	            {data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart +1;
                    }
                },
	            {data: 'product'},
	            {data: 'date'},
	            {data: 'qty'},
	            {data: 'desc'},
	            {data: 'status'},
	            {data: 'action'}
	        ]
	    });
	    // Function Click Create
        $('#create').click(function(){
            $('#save').val('create');
            $('#id').val('');
            $('#form').trigger('reset');
            $('#modal-header').html('Tambah kerugian');
            $('#modal').modal('show');
        });
        // Function Add or Edit
        $('#save').on('click', function(e){
            e.preventDefault();
            $(this).html('Menyimpan...');
            $.ajax({
                data: $('#form').serialize(),
                url: '{{route('loss.store')}}',
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    $('#save').html('Simpan');
                    $('#form').trigger('reset');
                    $('#modal').modal('hide');
                    table.draw();
					$.bigBox({
                        title : "Berhasil!",
                        content : data.success,
                        color : "#739E73",
                        timeout: 4000,
                        icon : "fa fa-check",
                    });
                },
                error: function(data){
                    $('#save').html('Simpan');
                    table.draw();
					$.smallBox({
                        title : "Error!",
                        content : data.responseJSON.error,
                        color : "#C46A69",
                        iconSmall : "fa fa-exclamation-circle bounce animated",
                        timeout : 4000
                    });
                }
            });
        });
        // Function Check
        $('body').on('click', '.check', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $.SmartMessageBox({
                title : "Apakah data sudah dicek?",
                content : "Data barang akan diupdate & status akan berubah menjadi checked",
                buttons : '[Batal][Lanjut]'
            }, function(ButtonPressed) {
                if (ButtonPressed === "Lanjut") {
                    $.ajax({
	                    type: 'GET',
                        url: '{{ url('loss') }}'+'/'+id,
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id
                        },
                        success: function(data){
                            table.draw();
	                        $.smallBox({
                                title : "Berhasil",
                                content : data.success,
                                color : "#659265",
                                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                                timeout : 3000
                            });
	                    },
                        error: function(data){
                            console.log('Error', data.responseJSON.error)
                        }
                    })
                }
                if (ButtonPressed === "Batal") {
                    $.smallBox({
                        title : "Batal!",
                        content : "<i class='fa fa-clock-o'></i> <i>Approve dibatalkan</i>",
                        color : "#3276B1",
                        iconSmall : "fa fa-warning fa-2x fadeInRight animated",
                        timeout : 3000
                    });
                }
            });
        });
        // Delete
        $('body').on('click', '.delete', function(){
            var id = $(this).data('id');
            $.SmartMessageBox({
                title : "Hapus Data!",
                content : "Data tidak akan kembali jika sudah dihapus",
                buttons : '[Batal][Hapus]'
            }, function(ButtonPressed) {
                if (ButtonPressed === "Hapus") {
                    $.ajax({
	                    type: 'DELETE',
                        url: '{{ url('loss') }}'+'/'+id,
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id
                        },
                        success: function(data){
                            table.draw();
	                        $.smallBox({
                                title : "Berhasil",
                                content : data.success,
                                color : "#659265",
                                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                                timeout : 3000
                            });
	                    },
                    })
                }
                if (ButtonPressed === "Batal") {
                    $.smallBox({
                        title : "Batal!",
                        content : "<i class='fa fa-clock-o'></i> <i>Data tersimpan</i>",
                        color : "#3276B1",
                        iconSmall : "fa fa-warning fa-2x fadeInRight animated",
                        timeout : 3000
                    });
                }
            });
        });
        // Get data
		$('#invoice').on('change', function(){
	        var id = $(this).find(':selected').val();
	        $.ajax({
	            url: '{{ route('loss.getdata')}}',
	            type: 'POST',
	            data: {
                    'id': id,
                    '_token': '{{ csrf_token() }}',
                },
	            dataType: 'json',
	            success: function(response){
	                console.log(response);
                    $('#price').val(response.data.price);
                    $('#product_id').val(response.data.product.name);
                    $('#purchase_qty').val(response.data.qty);
	                $('#date').val(new Date(response.data.created_at).toLocaleDateString());
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
            var qty = $('#qty').val();
            var product_qty = $('#product_qty').val();
            var qty = $(this).val();
            total = price * qty;
            if (total) {
                if (qty >= product_qty) {
                    $('#total').text('Melebihi jumlah pembelian');
                } else {
                    $('#total').val(total);
                }
            } else {
                $('#total').val(0);
            }
        })
        /* ------------------------------ */
	})	
</script>
@endpush