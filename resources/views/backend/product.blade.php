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
                <i class="fa fa-dropbox fa-fw "></i> 
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
                            <th rowspan="2" class="text-center" width="30px">NO</th>
                            <th rowspan="2" class="text-center"><span class="label label-info">KODE</span> NAMA BARANG</th>
                            <th rowspan="2" class="text-center">KATEGORI</th>
                            <th rowspan="2" class="text-center">TEMPAT</th>
                            <th rowspan="2" class="text-center">HARGA</th>
                            <th colspan="3" class="text-center">STOK</th>
                            <th rowspan="2" class="text-center" width="80px" class="text-center">AKSI</th>
                        </tr>
                        <tr>
                            <th width="50px">SEKARANG</th>
                            <th width="50px">MASUK</th>
                            <th width="50px">RUGI</th>
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
                <form id="form" name="form" class="form" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Kode Barang:*</label>
                                <input type="text" id="code" name="code" placeholder="Masukan Kode" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Barang:*</label>
                                <input type="text" id="name" name="name" placeholder="Masukan Nama Barang" class="form-control">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id">Kategori:*</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <select name="category_id" id="category_id" style="width: 100%" class="select2">
                                                <option value="">Pilih</option>
                                                <optgroup label="Kategori">
                                                    @foreach ($category as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <div class="input-group-btn">
                                                <a href="#" class="btn btn-info"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="place_id">Tempat Barang:*</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <select name="place_id" id="place_id" style="width: 100%" class="select2">
                                                <option value="">Pilih</option>
                                                <optgroup label="Tempat Barang">
                                                    @foreach ($place as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <div class="input-group-btn">
                                                <a href="#" class="btn btn-info"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="qty">Stok:</label>
                                <input type="number" id="qty" name="qty" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="purchase_qty">Pemasukan:</label>
                                <input type="number" id="purchase_qty" name="purchase_qty" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="loss_qty">Rugi:</label>
                                <input type="number" id="loss_qty" name="loss_qty" class="form-control" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Foto Barang:</label>
                                <input type="file" id="image" name="image" class="form-control">
                                <span class="text-muted">(Abaikan jika tidak ingin menambahkan atau merubah photo)</span>
                            </div>
                            <div class="form-group">
                                <label for="price">Harga:*</label>
                                <input type="text" placeholder="Masukan Harga Jual Barang" class="form-control" id="price" name="price">
                            </div>
                        </div>
                    </div>
                </form>
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
<!-- modal -->
<div id="modal" class="modal fade" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modal-header"></h5>
            </div>
            <form id="form" name="form" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Produk</label>
                        <input type="text" id="code" name="code" placeholder="Masukan Kode untuk Barang" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" id="name" name="name" placeholder="Masukan Nama Barang" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category_id" id="category_id" class="form-control select-search">
                            <option value="">Pilih</option>
                            <optgroup label="Kategori">
                                @foreach ($category as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        <a href="{{ route('category.index') }}">Tambah kategori</a>
                    </div>
                    <div class="form-group">
                        <label>Tempat Barang</label>
                        <select name="place_id" id="place_id" class="form-control select-search">
                            <option value="">Pilih</option>
                            <optgroup label="Tempat Barang">
                                @foreach ($place as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        <a href="{{ route('place.index') }}">Tambah tempat</a>
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" id="image" name="image" class="form-control">
                        <span class="text-muted">Abaikan jika tidak ingin menambahkan atau merubah photo.</span>
                    </div>
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="number" id="qty" name="qty" class="form-control" value="" readonly>
                    </div>
                    <input type="hidden" id="purchase_qty" name="purchase_qty" class="form-control">
                    <input type="hidden" id="loss_qty" name="loss_qty" class="form-control">
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" placeholder="Masukan Harga Jual Barang" class="form-control" id="price" name="price">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-primary submit" id="save" value="create">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- photo modal -->
<div class="modal" id="modal-image">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Detail Barang</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="image" style="display:none">
                    <img src="" style="height:300px;width:300px">
                    <span id="uploaded_image"></span>
                </div>
            </div>
            <!-- Modal footer -->
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
                {data: 'purchase_qty', name: 'purchase_qty'},
                {data: 'loss_qty', name: 'loss_qty'},
                {data: 'action', orderable: false, searchable: false}
            ]
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
            $('#loss_qty').val(0);
            $('#modal').modal('show');
        });
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
                        title : "Error!",
                        content : "<i class='fa fa-clock-o'></i>Tolong isi semua form yang ada.",
                        color : "#C46A69",
                        iconSmall : "fa fa-exclamation-circle bounce animated",
                        timeout : 4000
                    });
                }
            });
        });
        // Image Modal
        $('body').on('click', '.detail', function(){
            $('#photoModal').modal('show');
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