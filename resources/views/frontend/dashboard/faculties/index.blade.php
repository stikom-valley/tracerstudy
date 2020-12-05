@extends('frontend.master')

@section('title', 'Fakultas')

@section('faculties', 'class=active')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Fakultas</h1>
        <div class="section-header-button ml-auto">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#create-faculty-modal"><i
                    class="fas fa-plus pr-2"></i>Fakultas Baru</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h4 class="text-dark"><i class="fas fa-list pr-2"></i> Daftar Fakultas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jumlah Jurusan</th>
                                        <th width="15%">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($faculties as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->majors()->count() }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('faculty.show', [$item->id]) }}"
                                                class="btn btn-sm btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('faculty.edit', $item->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-danger">
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
    </div>
</section>
@include('frontend.dashboard.faculties.create')
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
                        url: '{{ url("dashboard/faculty")}}/' + id,
                        method: 'DELETE',
                        success: function (data) {
                            console.log(data);
                            swal("Data berhasil dihapus", {
                                icon: "success",
                            });
                        }
                    })

                }
            });
    });

    $('#btn-save-faculty').click(function (e) {
        e.preventDefault();
        var form = $('#form-create-faculty');

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
                    '<div class="alert alert-warning" role="alert">Ada yang salah, silahkan muat ulang laman ini </div>');
            });
    });

    
    $('#btn-cancel-save-faculty').click(function (e) {
        var form = $('#form-create-faculty');
        form.find('.message').html('');
        $("#name").val('');
    });

    });

</script>
@endsection