@extends('layouts.pages.master')

@section('title', 'Barang')

@section('content')
<!-- HEADER -->
<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>
    <ol class="breadcrumb">
        <li>Home</li><li>Master Barang</li><li>Barang</li>
    </ol>
</div>
<!-- END HEADER -->			

<!-- MAIN CONTENT -->
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-cubes fa-fw "></i> 
                    Master Barang
                <span>>  
                    Barang
                </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <a href="javascript:void(0);" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i> Import / Export</a>
                </li>
                <li class="sparks-info">
                    <a href="javascript:void(0);" class="btn btn-primary btn-flat" id="create"><i class="fa fa-plus"></i> Tambah Barang</a>
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
                            <th data-hide="phone" class="text-center" width="30px">NO</th>
                            <th data-class="expand" class="text-center"> <span class="label label-info">KODE</span> <i class="fa fa-fw fa-cube text-muted hidden-md hidden-sm hidden-xs"></i> NAMA BARANG</th>
                            <th data-hide="phone,tablet" class="text-center"><i class="fa fa-fw fa-cube text-muted hidden-md hidden-sm hidden-xs"></i> KATEGORI</th>
                            <th data-hide="phone,tablet" class="text-center"><i class="fa fa-fw fa-archive text-muted hidden-md hidden-sm hidden-xs"></i> TEMPAT</th>
                            <th data-hide="phone,tablet" class="text-center"><i class="fa fa-fw fa-eur text-muted hidden-md hidden-sm hidden-xs"></i> HARGA</th>
                            <th data-hide="phone,tablet" width="50px" class="text-center">STOK</th>
                            <th class="text-center" width="110px" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </article>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" data-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-header"></h4>
            </div>
            <div class="modal-body">
                <form id="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Kode Barang:<span class="text-danger">*</span></label>
                                <input type="text" id="code" name="code" placeholder="Masukan Kode" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Barang:<span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" placeholder="Masukan Nama Barang" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id">Kategori:<span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <select name="category_id" id="category_id" style="width: 100%" class="select2">
                                                <optgroup label="Kategori">
                                                    @foreach ($category as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <div class="input-group-btn">
                                                <a href="{{ route('category.index') }}" class="btn btn-info"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="place_id">Tempat Barang:<span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <select name="place_id" id="place_id" style="width: 100%" class="select2">
                                                <optgroup label="Tempat Barang">
                                                    @foreach ($place as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <div class="input-group-btn">
                                                <a href="{{ route('place.index') }}" class="btn btn-info"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="qty">Stok:</label>
                                <input type="number" id="qty" name="qty" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="purchase_qty">Pemasukan:</label>
                                <input type="number" id="purchase_qty" name="purchase_qty" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sales_qty">Penjualan:</label>
                                <input type="number" id="sales_qty" name="sales_qty" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="loss_qty">Rugi:</label>
                                <input type="number" id="loss_qty" name="loss_qty" class="form-control" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Foto Barang: <span class="text-muted">(Abaikan jika tidak ingin menambah atau merubah photo)</span></label>
                                <input type="file" id="image" name="image" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Harga:<span class="text-danger">*</span></label>
                                <input type="text" placeholder="Masukan Harga Jual Barang" class="form-control" id="price" name="price">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="text-muted float-left">Keterangan: Tanda <code>(*)</code> wajib diisi!</span>
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

<!-- Detail modal -->
<div class="modal" id="detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-detail">Detail Barang</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>KODE BARANG</th>
                            <th width="10px">:</th>
                            <td><span id="code"></span></td>
                        </tr>
                        <tr>
                            <th>NAMA BARANG</th>
                            <th width="10px">:</th>
                            <td><span id="name"></span></td>
                        </tr>
                        <tr>
                            <th>KATEGORI</th>
                            <th width="10px">:</th>
                            <td><span id="category"></span></td>
                        </tr>
                        <tr>
                            <th>TEMPAT</th>
                            <th width="10px">:</th>
                            <td><span id="place"></span></td>
                        </tr>
                        <tr>
                            <th>HARGA</th>
                            <th width="10px">:</th>
                            <td><span id="price"></span></td>
                        </tr>
                        <tr>
                            <th>STOK</th>
                            <th width="10px">:</th>
                            <td><span id="qty"></span></td>
                        </tr>
                        <tr>
                            <th>BARANG MASUK</th>
                            <th width="10px">:</th>
                            <td><span id="purchase_qty"></span></td>
                        </tr>
                        <tr>
                            <th>TERJUAL</th>
                            <th width="10px">:</th>
                            <td><span id="sales_qty"></span></td>
                        </tr>
                        <tr>
                            <th>RUGI</th>
                            <th width="10px">:</th>
                            <td><span id="loss_qty"></span></td>
                        </tr>
                        <tr>
                            <th>FOTO BARANG</th>
                            <th width="10px">:</th>
                            <td><span id="image"></span></td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- /photo modal -->
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        
        // Function Datatable
        var responsiveTable = undefined;
        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };
        var table = $('#table').DataTable({
            serverSide: true,
            responsive: true,
            autoWidth: true,
            ajax: '{{route('product.index')}}',
            columns: [
                {data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart +1;
                    }
                },
                {data: 'name'},
                {data: 'category.name', orderable: false, searchable: false},
                {data: 'place.name'},
                {data: 'price', name: 'price'},
                {data: 'qty', name: 'qty'},
                {data: 'action', orderable: false, searchable: false}
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
            $('#category_id').val('');
            $('#place_id').val('');
            $('#form').trigger('reset');
            $('#modal-header').html("Tambah Barang")
            $('#qty').val(0);
            $('#purchase_qty').val(0);
            $('#sales_qty').val(0);
            $('#loss_qty').val(0);
            $('#modal').modal('show');
        });

        // Function Detail
        $('body').on('click', '.detail', function() {
            var id = $(this).data('id');
            $.get('{{ url('product') }}'+'/'+id, function(data){
                $('#detail').modal('show');
                $('#code').val(data.code);
                $('#name').html(data.name);
                $('#category').html(data.category_id);
                $('#place').html(data.place_id);
                $('#price').html(data.price);
                $('#qty').html(data.qty);
                $('#purchase_qty').html(data.purchase_qty);
                $('#sales_qty').html(data.sales_qty);
                $('#loss_qty').html(data.loss_qty);
                $('#image').html(data.image);
            })
        })

        // Function Click Save in Modal
        $('#save').on('click', function(e){
            e.preventDefault();
            $(this).html('Menyimpan...');
            $.ajax({
                data: $('#form').serialize(),
                url: '{{route('product.store')}}',
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
                    console.log('Error', data);
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

        // Function Edit Modal
        $('body').on('click', '.edit', function(){
            var id = $(this).data('id');
            $.get('{{ route('product.index') }}'+'/'+ id +'/edit', function(data){
                $('#modal-header').html('Edit Barang')
                $('#save').val('update');
                $('#modal').modal('show');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#code').val(data.code);
                $('#category_id').val(data.category_id);
                $('#place_id').val(data.place_id);
                $('#qty').val(data.qty);
                $('#price').val(data.price)
            })
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
                        url: '{{ route('product.store') }}'+'/'+id,
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
    });
</script>
@endpush