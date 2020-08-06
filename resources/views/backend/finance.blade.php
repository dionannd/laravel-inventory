@extends('layouts.pages.master')

@section('title', 'Keuangan')

@section('content')
<!-- page header -->
<div class="page-header page-header-light border-bottom-1 border-bottom-primary">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-left2 mr-2"></i> <span class="font-weight-semibold">Keuangan</span></h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <span class="breadcrumb-item active">Keuangan</span>
            </div>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- content area -->
<div class="content">
    <div class="card">
        <div class="card-header bg-primary text-white header-elements-inline">
            <h6 class="card-title"><span class="font-weight-semibold">Data Keuangan</span></h6>
            <a href="javascript:void(0)" class="btn btn-success" id="create">Tambah <i class="icon-file-plus2"></i></a>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th width="50px">No</th>
                        <th width="50px">Kode</th>
                        <th>Pembayaran</th>
                        <th>Saldo</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Tgl Pembuatan</th>
                        <th width="140px" class="text-center">Aksi</th>
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
                        <label>Kode Akun Pembayaran</label>
                        <input type="number" id="code" name="code" placeholder="Masukan Kode Akun Pembayaran" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Akun</label>
                        <input type="text" id="name" name="name" placeholder="Masukan Nama Pembayaran" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="desc" id="desc" rows="3" cols="3" placeholder="Masukan deskripsi" class="form-control"></textarea>
                        <span class="form-text" id="error-desc"></span>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category" id="category" class="form-control select-search">
                            <option value="">-Pilih-</option>
                            <optgroup label="Kategori Pembayaran">
                                <option value="Penjualan">Penjualan</option>
                                <option value="Pembelian">Pembelian</option>
                                <option value="Hutang">Hutang</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Saldo</label>
                        <input type="number" id="balance" name="balance" placeholder="Masukan Saldo" class="form-control">
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
        // Function DataTable
        var table = $('#table').DataTable({
            serverSide: true,
            ajax: '{{route('finance.index')}}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'code', name: 'code'},
                {data: 'name', name: 'name'},
                {data: 'balance', name: 'balance'},
                {data: 'category', name: 'category'},
                {data: 'desc', name: 'desc'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', orderable: false, searchable: false}
            ]
        })
        // Function Click Create
        $('#create').click(function(){
            $('#save').val('create');
            $('#id').val('');
            $('#form').trigger('reset');
            $('#modal-header').html('Tambah Keuangan');
            $('#modal').modal('show');
        });
        // Function Click Save in Modal
        $('#save').on('click', function(e){
            e.preventDefault();
            $(this).html('Menyimpan...');
            $.ajax({
                data: $('#form').serialize(),
                url: '{{route('finance.store')}}',
                type: 'POST',
                dataType: 'JSON',
                success: function(data){
                    $('#save').html('Simpan');
                    $('#form').trigger('reset');
                    $('#modal').modal('hide');
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
            $.get('{{ route('finance.index') }}'+'/'+ id +'/edit', function(data){
                $('#modal-header').html('Edit Data Keuangan')
                $('#save').val('update');
                $('#modal').modal('show');
                $('#id').val(data.id)
                $('#code').val(data.code);
                $('#name').val(data.name);
                $('#desc').val(data.desc);
                $('#category').find('option:selected').val();
                $('#balance').val(data.balance);
            })
        });
        // Function Click Delete
        $('body').on('click', '.delete', function(){
            var id = $(this).data('id');
            swal({
                title: "Apa kau yakin?",
                text: "Ingin menghapus data ini!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Iya, hapus!',
                cancelButtonText: 'Tidak, batal',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'finance/delete'+'/'+ id,
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
                            table.ajax.reload();
                        },
                        error: function(data){
                            console.log('Error', data);
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