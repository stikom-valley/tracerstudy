@extends('frontend.master')

@section('title', 'Fakultas')

@section('faculties', 'class=active')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('faculty.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ $faculty->name }}</h1>
        <div class="section-header-button ml-auto">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#create-major-modal"><i
                    class="fas fa-plus pr-2"></i>Jurusan Baru</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h4 class="text-dark"><i class="fas fa-list pr-2"></i> Daftar Jurusan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th width="15%">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($majors as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('faculty.edit', $item->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" data-id="{{ $item->id }}" class="btn delete btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h4 class="text-info">
                            <i class="fas fa-edit pr-2"></i>Form Edit
                        </h4>
                    </div>
                    <form action="{{ route('faculty.update', $faculty->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama Fakultas <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $faculty->name }}">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-info"><i class="fas fa-save pr-2"></i>Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card card-danger">
                    <div class="card-header">
                        <h4 class="text-danger">
                            <i class="fas fa-trash-alt pr-2"></i>Hapus
                        </h4>
                    </div>
                    <form action="{{ route('faculty.destroy', $faculty->id) }}" method="post">
                        @csrf
                        <div class="card-body">
                            <p>Form ini akan menghapus <b>{{ $faculty->name }}</b> beserta <b>Jurusan</b>. Data yang
                                sudah dihapus tidak bisa dikembalikan. Silakan pikirkan matang-matang.</p>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-danger btn-icon icon-left">
                                <i class="fas fa-trash-alt"></i> Ya, Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend.dashboard.majors.create')
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $("#table-1").dataTable();

        function ajax() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
        $(document).on('click', '.delete', function () {
            var id = $(this).data('id');
            swal({
                    title: "Apa kamu yakin ?",
                    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        ajax();
                        $.ajax({
                            url: '/dashboard/major/' + id,
                            method: 'DELETE',
                            success: function (response) {
                                if (response.status == true) {
                                    swal(response.message, {
                                        icon: "success",
                                    }).then((results) => {
                                        location.reload(true);
                                    });
                                }
                            }
                        })

                    }
                });
        });

        $('#btn-save-major').click(function (e) {
            e.preventDefault();
            var form = $('#form-create-major');

            $.ajax({
                    method: 'POST',
                    dataType: 'json',
                    url: form.attr('action'),
                    data: form.serialize()
                })
                .done(function (response) {
                    form.find('.message').html(response.message);

                    if (response.status == true) {
                        location.reload(true);
                    }
                })
                .fail(function (response) {
                    form.find('.message').html(
                        '<div class="alert alert-warning" role="alert">Ada yang salah, silahkan muat ulang laman ini </div>'
                        );
                });
        });


        $('#btn-cancel-save-major').click(function (e) {
            var form = $('#form-create-major');
            form.find('.message').html('');
            $("#name").val('');
        });

    });

</script>
@endsection
