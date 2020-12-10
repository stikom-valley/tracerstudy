@extends('frontend.master')

@section('title', 'Kelulusan')

@section('educations', 'class=active')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Kelulusan</h1>
        <div class="section-header-button ml-auto">
            <a href="{{ route('education.create') }}" class="btn btn-primary"><i
                    class="fas fa-plus pr-2"></i>Kelulusan Baru</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h4 class="text-dark"><i class="fas fa-list pr-2"></i> Daftar Alumni</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Tahun Lulus</th>
                                        <th>Jumlah Alumni</th>
                                        <th width="15%">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($educations as $item)
                                    <tr>
                                        <td>{{ $item->graduation_year }}</td>
                                        <td>{{ $item->total_user }}</td>
                                        <td class="text-center">
                                            <a href="#"
                                                class="btn btn-sm btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn delete btn-sm btn-danger">
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
                        url: '{{ url("dashboard/question")}}/' + id,
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
    });

</script>
@endsection