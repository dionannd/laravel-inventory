@extends('layouts.pages.master')

@section('title', 'Pengeluaran')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light border-bottom-1 border-bottom-primary">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-left2 mr-2"></i> <span class="font-weight-semibold">Pengeluaran</span></h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <span class="breadcrumb-item active">Pengeluaran</span>
            </div>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- Content area -->
<div class="content">
    <div class="card">
        <div class="card-header bg-primary text-white header-elements-inline">
            <h6 class="card-title"><span class="font-weight-semibold">Data Pengeluaran</span></h6>
            <a href="javascript:void(0)" class="btn btn-success" id="create">Tambah <i class="icon-file-plus2"></i></a>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th width="50px" class="text-center">No</th>
                        <th>Biaya</th>
                        <th>Pembayaran</th>
                        <th>Nominal</th>
                        <th>Deskripsi</th>
                        <th>Tgl Pengeluaran</th>
                        <th width="50px" class="text-center">Aksi</th>
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
                        <label>Name Biaya</label>
                        <input type="text" id="expense" name="expense" placeholder="Masukan Nama Biaya" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Pembayaran</label>
                        <select name="finance_id" id="finance_id" class="form-control select-search">
                            <option value="">Pilih</option>
                            <optgroup label="Pilih Pembayaran">
                                @foreach ($finance as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="desc" id="desc" rows="3" cols="3" placeholder="Masukan Deskripsi Biaya" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="number" id="nominal" name="nominal" placeholder="Masukan Nominal Pengeluaran" class="form-control">
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
<script type="text/javascript">
    $(document).ready(function(){
        // DataTable
        var table = $('#table').DataTable({
            serverSide: true,
            ajax: '{{route('cashout.index')}}',
            columns: [
                {data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart +1;
                    }
                },
                {data: 'expense', name: 'expense'},
                {data: 'finance.name', name: 'finance.name'},
                {data: 'nominal', name: 'nominal'},
                {data: 'desc', name: 'desc'},
                {data: 'created_at', name: 'created_at'},
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
                    $('#save').html('Simpan');
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
                        url: 'cashout/delete'+'/'+ id,
                        type: 'GET',
                        success: function(response){
                            new Noty({
                                theme: ' alert alert-success alert-styled-left p-0',
                                text: response.success,
                                type: 'success',
                                progressBar: false,
                                timeout: 2000,
                                closeWith: ['button']
                            }).show();
                            table.ajax.reload();
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
        
    });
</script>
@endpush