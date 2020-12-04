@extends('frontend.master')

@section('title', 'Pengguna')

@section('experiences', 'class=active')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Riwayat Pekerjaan {{ $user->name }}</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h4 class="text-dark"><i class="fas fa-list pr-2"></i> Daftar Riwayat Pekerjaan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>Nama Perusahaan</th>
                                            <th>Jabatan</th>
                                            <th>Mulai Bekerja</th>
                                            <th>Berhenti Bekerja</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($exper as $item)
                                            <tr>
                                                <td>{{ $item->company_name }}</td>
                                                <td>{{ $item->job_title }}</td>
                                                <td>{{ $item->start_date }}</td>
                                                <td>{{ $item->end_date }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-secondary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                <a href="{{route('experience.edit',[$item->id])}}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" data-id="{{ $item->id }}"
                                                        class="btn delete btn-sm btn-danger">
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
        $(document).ready(function() {
            $("#table-1").dataTable();


            function ajax() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }
            $(document).on('click', '.delete', function() {
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
                                url: '{{ url("dashboard/experience") }}/' + id,
                                method: 'DELETE',
                                success: function(data) {
                                    swal("Data berhasil dihapus", {
                                        icon: "success",
                                    });
                                    setTimeout(function() {
                                        window.location.href =
                                            "{{ route('experience.index') }}"
                                    }, 1500)
                                }
                            })

                        }
                    });
            })
        });

    </script>
@endsection
