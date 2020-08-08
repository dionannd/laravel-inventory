@extends('layouts.pages.master')

@section('title', 'Pengeluaran')

@section('content')
<!-- HEADER -->
<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>
    <ol class="breadcrumb">
        <li>Home</li><li>Master Keuangan</li><li>Pengeluaran</li>
    </ol>
</div>
<!-- END HEADER -->			
<!-- MAIN CONTENT -->
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-users fa-fw "></i> 
                    Master Keuangan
                <span>>  
                    Pengeluaran
                </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <a href="javascript:void(0);" class="btn btn-success btn-flat"><i class="fa fa-file-excel-o"></i> Import / Export</a>
                </li>
                <li class="sparks-info">
                    <a href="javascript:void(0);" class="btn btn-primary btn-flat" id="create"><i class="fa fa-plus"></i> Tambah Pengeluaran</a>
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
                            <th>NAMA BIAYA</th>
                            <th>AKUN PEMBAYARAN</th>
                            <th>NOMINAL</th>
                            <th>DESKRIPSI</th>
                            <th>TANGGAL</th>
                            <th width="30px" class="text-center">AKSI</th>
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
                <form id="form" name="form" class="form">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="expense">Name Biaya</label>
                        <input type="text" id="expense" name="expense" placeholder="Masukan Nama Biaya" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="finance_id">Pembayaran</label>
                        <select name="finance_id" id="finance_id" class="select2">
                            <optgroup label="Pilih Pembayaran">
                                @foreach ($finance as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="desc">Deskripsi</label>
                        <textarea name="desc" id="desc" rows="3" cols="3" placeholder="Masukan Deskripsi Biaya" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="number" id="nominal" name="nominal" placeholder="Masukan Nominal Pengeluaran" class="form-control">
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
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        // DataTable
        var table = $('#table').DataTable({
            serverSide: true,
            responsive: true,
            autoWidth: true,
            ajax: '{{route('cashout.index')}}',
            columns: [
                {data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart +1;
                    }
                },
                {data: 'expense'},
                {data: 'finance.name'},
                {data: 'nominal'},
                {data: 'desc'},
                {data: 'created_at'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        // Function Click Create
        $('#create').click(function(){
            $('#save').val('create');
            $('#id').val('');
            $('#form').trigger('reset');
            $('#modal-header').html('Tambah Pengeluaran');
            $('#modal').modal('show');
        });
        // Function Add or Edit
        $('#save').on('click', function(e){
            e.preventDefault();
            $(this).html('Menyimpan...');
            $.ajax({
                data: $('#form').serialize(),
                url: '{{route('cashout.store')}}',
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
        // Function Click Edit
        $('body').on('click', '.edit', function(){
            var id = $(this).data('id');
            $.get('{{ route('cashout.index') }}'+'/'+ id +'/edit', function(data){
                $('#modal-header').html('Edit Pengeluaran');
                $('#save').val('update');
                $('#modal').modal('show');
                $('#id').val(data.id)
                $('#expense').val(data.expense);
                $('#finance_id').find('option:selected').val();
                $('#desc').val(data.desc);
                $('#nominal').val(data.nominal);
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
                        url: '{{ route('cashout.store') }}'+'/'+id,
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