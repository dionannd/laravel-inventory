@extends('layouts.pages.master')

@section('title', 'Pelanggan')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light border-bottom-1 border-bottom-primary">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-left2 mr-2"></i> <span class="font-weight-semibold">Pelanggan</span></h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <span class="breadcrumb-item active">Pelanggan</span>
            </div>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- content area -->
<div class="content">
    <div class="card">
        <div class="card-header bg-primary text-white header-elements-inline">
            <h6 class="card-title"><span class="font-weight-semibold">Data Pelanggan</span></h6>
            <a href="javascript:void(0)" class="btn btn-success" id="create">Tambah <i class="icon-file-plus2"></i></a>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th width="50px">No</th>
                        <th>Nama Pelanggan</th>
                        <th>No. Telp</th>
                        <th>Email</th>
                        <th>Alamat</th>
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
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input type="text" id="name" name="name" placeholder="Masukan Nama Pelanggan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>No. Hp</label>
                        <input type="integer" id="phone" name="phone" placeholder="Masukan Nomor Telp" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukan email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" id="address" name="address" placeholder="Masukan alamat" class="form-control">
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
        // Function DataTable
        var table = $('#table').DataTable({
            serverSide: true,
            ajax: '{{route('customer.index')}}',
            columns: [
                {data: "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart +1;
                    }
                },
                {data: 'name', na{data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        // Function Click Create
        $('#create').click(function(){
            $('#save').val('create');
            $('#id').val('');
            $('#form').trigger('reset');
            $('#modal-header').html('Tambah Pelanggan')
            $('#modal').modal('show');
        });
        // Function Click Save in Modal
        $('#save').on('click', function(e){
            e.preventDefault();
            $(this).html('Menyimpan...');
            $.ajax({
                data: $('#form').serialize(),
                url: '{{route('customer.store')}}',
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
                        text: response.responseJSON.error,
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
            $.get('{{ route('customer.index') }}'+'/'+ id +'/edit', function(data){
                $('#modal-header').html('Edit Pelanggan')
                $('#btn-save').val('update');
                $('#modal').modal('show');
                $('#id').val(data.id)
                $('#name').val(data.name);
                $('#phone').val(data.phone);
                $('#email').val(data.email);
                $('#address').val(data.address);
            })
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
                        url: 'customer/delete'+'/'+ id,
                        type: 'GET',
                        success: function(data){
                            new Noty({
                                theme: ' alert alert-success alert-styled-left p-0',
                                text: data.success,
                                type: 'success',
                                progressBar: false,
                                timeout: 2000,
                                closeWith: ['button']
                            }).show();
                            table.ajax.reload()
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