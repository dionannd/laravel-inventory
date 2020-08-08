@extends('layouts.pages.master')

@section('title', 'Penjualan Barang')

@section('content')
<!-- HEADER -->
<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>
    <ol class="breadcrumb">
        <li>Home</li><li>Master Transaksi</li><li>Penjualan Barang</li>
    </ol>
</div>
<!-- END HEADER -->			

<!-- MAIN CONTENT -->
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-truck fa-fw "></i> 
                    Master Transaksi
                <span>>  
                    Penjualan Barang
                </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <a href="javascript:void(0);" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i> Import / Export</a>
                </li>
                <li class="sparks-info">
                    <a href="javascript:void(0);" class="btn btn-primary btn-flat" id="create"><i class="fa fa-plus"></i> Tambah Penjualan</a>
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
                            <th data-hide="phone" width="30px">NO</th>
                            <th data-class="expand">INVOICE</th>
                            <th data-hide="phone,tablet">PELANGGAN</th>
                            <th data-hide="phone,tablet">BARANG</th>
                            <th data-hide="phone,tablet" width="80px">QTY</th>
                            <th data-hide="phone,tablet">TGL PENJUALAN</th>
                            <th data-hide="phone,tablet" width="50px">STATUS</th>
                            <th width="110px" class="text-center">AKSI</th>
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
                <h4 class="modal-title" id="modal-header"></h4>
            </div>
            <div class="modal-body">
                <form id="form" name="form">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="invoice">Invoice:<span class="text-danger">*</span></label>
                                <input type="text" id="invoice" name="invoice" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="product_id">Nama Barang:<span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <select name="product_id" id="product_id" style="width: 100%" class="select2">
                                                <option value="">Pilih Barang</option>
                                                <optgroup label="Barang">
                                                    @foreach ($product as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <div class="input-group-btn">
                                                <a href="{{ route('product.index') }}" class="btn btn-info"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="product_qty">Stok:</label>
                                <input type="text" id="product_qty" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="customer_id">Nama Pelanggan:<span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <select name="customer_id" id="customer_id" style="width: 100%" class="select2">
                                        <optgroup label="Supplier">
                                            @foreach ($customer as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <div class="input-group-btn">
                                        <a href="{{ route('customer.index') }}" class="btn btn-info"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="finance_id">Akun Pemasukan:<span class="text-danger">*</span></label>
                                <select name="finance_id" id="finance_id" class="select2" data-fouc>
                                    <optgroup label="Pilih Pembayaran">
                                        @foreach ($finance as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="qty">Qty:<span class="text-danger">*</span></label>
                                <input type="number" id="qty" name="qty" value="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Deskripsi:</label>
                                <textarea name="desc" id="desc" cols="3" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Harga:<span class="text-danger">*</span></label>
                                <input type="number" id="price" name="price" placeholder="Pilih Barang" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cost">Biaya Kirim:</label>
                                <input type="number" id="cost" name="cost" value="0" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total">Total:<span class="text-danger">*</span></label>
                                <input type="number" id="total" name="total" value="0" class="form-control" readonly>
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
                                <button type="submit" class="btn btn-primary" id="save" value="create">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END CONTENT -->
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        
        // Function DataTable
        var responsiveTable = undefined;
        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };
        var table = $('#table').DataTable({
            destroy: true,
            serverSide: true,
            ajax: '{{route('sales.index')}}',
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'invoice'},
                {data: 'customer.name'},
                {data: 'product'},
                {data: 'qty'},
                {data: 'created_at'},
                {data: 'status'},
                {data: 'action'},
            ],
            sDom: "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
                "t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            
            preDrawCallback : function() {
                if (!responsiveTable) {
                    responsiveTable = new ResponsiveDatatablesHelper($('#table'), breakpointDefinition);
                }
            },
            rowCallback : function(nRow) {
                responsiveTable.createExpandIcon(nRow);
            },
            drawCallback : function(oSettings) {
                responsiveTable.respond();
            }
        });

        // Function Click Create
        $('#create').click(function(){
            $('#save').val('create');
            $('#id').val('');
            $('#form').trigger('reset');
            $('#modal-header').html('<i class="fa fa-cart"></i> Tambah Penjualan');
            $('#modal').modal('show');
            $('#invoice').val('{{ $invoice }}');
            $('#product_qty').val(0);
        });

        // Function Add or Edit
        $('#save').on('click', function(e){
            e.preventDefault();
            $(this).html('Menyimpan...');
            $.ajax({
                data: $('#form').serialize(),
                url: '{{route('sales.store')}}',
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    $('#save').html('Simpan');
                    $('#form').trigger('reset');
                    $('#modal').modal('hide');
                    table.draw();
					$.bigBox({
                        title : "<i>Berhasil!</i>",
                        content : data.success,
                        color : "#739E73",
                        timeout: 4000,
                        icon : "fa fa-check",
                    });
                },
                error: function(data){
                    $('#save').html('Simpan');
					$.smallBox({
                        title : "<i>Error!</i>",
                        content : data.responseJSON.error,
                        color : "#C46A69",
                        iconSmall : "fa fa-exclamation-circle bounce animated",
                        timeout : 4000
                    });
                }
            });
        });

        // Function Aprrove
        $('body').on('click', '.approve', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $.SmartMessageBox({
                title : "Approve Data!",
                content : "Data akan diupdate & status akan berubah approve",
                buttons : '[Batal][Approve]'
            }, function(ButtonPressed) {
                if (ButtonPressed === "Approve") {
                    $.ajax({
	                    type: 'GET',
                        url: '{{ url('sales') }}'+'/'+id,
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id
                        },
                        success: function(data){
                            table.draw();
	                        $.smallBox({
                                title : "<i>Berhasil</i>",
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
                        title : "<i>Batal!</i>",
                        content : "<i class='fa fa-clock-o'></i> <i>Approve dibatalkan</i>",
                        color : "#3276B1",
                        iconSmall : "fa fa-warning fa-2x fadeInRight animated",
                        timeout : 3000
                    });
                }
            });
        });

        // Function Delete
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
                        url: '{{ route('sales.store') }}'+'/'+id,
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id
                        },
                        success: function(data){
                            table.draw();
	                        $.smallBox({
                                title : "<i>Berhasil</i>",
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
                        title : "<i>Batal!</i>",
                        content : "<i class='fa fa-clock-o'></i> <i>Data tersimpan</i>",
                        color : "#3276B1",
                        iconSmall : "fa fa-warning fa-2x fadeInRight animated",
                        timeout : 3000
                    });
                }
            });
        });

        // Function Get price from product
        $('#product_id').on('change', function(){
            var id = $(this).find(':selected').val();
            $.ajax({
                url: '{{ route('sales.price')}}',
                type: 'POST',
                data: {
                    'id': id,
                    '_token': '{{ csrf_token() }}',
                },
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    $('#price').val(response.data.price);
                    $('#product_qty').val(response.data.qty);
                    $('#total').val(response.data.price);
                },
            });
        });

        // Function SubTotal
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