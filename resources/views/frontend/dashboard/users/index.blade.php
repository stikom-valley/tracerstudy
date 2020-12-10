@extends('frontend.master')

@section('title', 'Pengguna')

@section('users', 'class=active')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Pengguna</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fas fa-plus pr-2"></i>Pengguna
                Baru</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Bagian Pengelola Alumni</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalBPA }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Wakil Rektor Alumni</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalWarek }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Alumni</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalAlumni }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h4 class="text-dark"><i class="fas fa-list pr-2"></i> Daftar Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>ID Pengguna</th>
                                        <th>Nama</th>
                                        <th>Hak Akses</th>
                                        <th width="15%">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $item)
                                    <tr>
                                        <td>{{ $item->reg_number }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @if ($item->role->slug == 'bpa')
                                            <div class="badge badge-success">{{ $item->role->name }}</div>
                                            @elseif($item->role->slug == 'warek-alumni')
                                            <div class="badge badge-primary">{{ $item->role->name }}</div>
                                            @elseif($item->role->slug == 'alumni')
                                            <div class="badge badge-info">{{ $item->role->name }}</div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('user.edit', $item->id) }}" class="btn btn-sm btn-info">
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
    </div>
</section>
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
                            url: '/dashboard/user/destroy/' + id,
                            method: 'POST',
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
    });
</script>
@endsection