@extends('layouts.pages.master')

@section('title', 'Kategori')

@section('content')
<!-- HEADER -->
<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>
    <ol class="breadcrumb">
        <li>Home</li><li>Master Barang</li><li>Kategori</li>
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
                    Kategori
                </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <a href="javascript:void(0);" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i> Import / Export</a>
                </li>
                <li class="sparks-info">
                    <a href="javascript:void(0);" class="btn btn-primary btn-flat" id="create"><i class="fa fa-plus"></i> Tambah Kategori</a>
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
                            <th data-class="expand"><i class="fa fa-fw fa-cube text-muted hidden-md hidden-sm hidden-xs"></i> NAMA KATEGORI</th>
                            <th data-hide="phone,tablet"><i class="fa fa-fw fa-comment text-muted hidden-md hidden-sm hidden-xs"></i> DESKRIPSI</th>
                            <th width="80px" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </article>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" data-backdrop="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-header"></h4>
            </div>
            <div class="modal-body">
                <form id="form"
                data-bv-message="Value ini tidak valid"
                data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label class="control-label" for="name">Nama Kategori:<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Kategori"
                        required
                        data-bv-notempty-message="Form tidak boleh kosong">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="desc">Deskripsi:</label>
                        <textarea class="form-control" name="desc" id="desc" rows="3" cols="3" placeholder="Masukan Deskripsi"
                        required
                        data-bv-notempty-message="Form tidak boleh kosong"></textarea>
                        <span class="text-danger">{{ $errors->first('desc') }}</span>
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
<script type="text/javascript">
    $(document).ready(function(){

        // Function DataTable
        var responsiveTable = undefined;
        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };
        var table = $('#table').DataTable({
            serverSide: true,
            responsive: true,
            autoWidth: true,
            ajax: '{{ route('category.index') }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'desc', name: 'desc'},
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
        $('#create').click(function()  {
            $('#save').val('create');
            $('#id').val('');
            $('#form').trigger('reset');
            $('#modal-header').html('Tambah Kategori');
            $('#modal').modal('show');
            $('#form').bootstrapValidator('resetForm', true);
        });

        // Function Click Save in Modal
        $('#save').click(function(e){
            e.preventDefault();
            $(this).html('Menyimpan...');
            $.ajax({
                data: $('#form').serialize(),
                url: '{{ route('category.store') }}',
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
            })
        });

        // Function Click Edit
        $('body').on('click', '.edit', function(){
            var id = $(this).data('id');
            $.get('{{ route('category.index') }}'+'/'+ id +'/edit', function(data){
                $('#modal-header').html('Edit Kategori');
                $('#save').val('update');
                $('#modal').modal('show');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#desc').val(data.desc);
            })
        });

        // Function Click Delete
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
                        url: '{{ route('category.store') }}'+'/'+id,
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id
                        },
                        success: function(data){
                            table.draw();
	                        $.smallBox({
                                title : "<i>Berhasil!</i>",
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
    });
</script>
@endpush