@extends('frontend.master')

@section('title', 'Pengguna')

@section('skills', 'class=active')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kompetensi {{ $user->name }}</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h4 class="text-dark"><i class="fas fa-list pr-2"></i> Daftar Kompetensi</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>Nama Kompetensi</th>
                                            <th>Sertifikat</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($skills as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->certification_document }}</td>
                                                <td>
                                                    {{-- <a href="#" class="btn btn-sm btn-secondary">
                                                        <i class="fas fa-eye"></i>
                                                    </a> --}}
                                                <a href="#" data-id="{{$item->id}}" class="btn editskill btn-sm btn-info">
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
    @include('frontend.dashboard.competence.edit')
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

            $(document).on('click','.editskill', function(){
                $('#modalCompetence').modal('show');
                var id = $(this).data('id');
                ajax();
                $.ajax({
                    url:'/dashboard/competence/'+id+'/edit',
                    method:'GET',
                    success:function(data){
                        $('#nama_alumni').val(data['user']['name']);
                       $('#nama_kompetensi').val(data['skill']['name']);
                       $('#sertifikat').val(data['skill']['certification_document']);
                       $('#id').val(id);
                       $('#formEdit').attr('action','/dashboard/competence/'+id);
                    }
                })
            });

            // $(document).on('click','.update', function(){
            //     var id = $('#id').val();
            //     var nama_kompetensi = $('#nama_kompetensi').val();
            //     var sertifikat = $('#sertifikat').val();

            //     ajax();
            //     $.ajax({
            //         url:'/dashboard/experience/'+id,
            //         method:'PUT',
            //         data:{
            //             'nama_kompetensi':nama_kompetensi,
            //             'sertifikat':sertifikat
            //         },success:function(data){
            //             console.log(data);
            //         }
            //     })
            // })

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
                                url: '{{ url("dashboard/competence") }}/' + id,
                                method: 'DELETE',
                                success: function(data) {
                                    swal("Data berhasil dihapus", {
                                        icon: "success",
                                    });
                                    setTimeout(function() {
                                        window.location.href =
                                            "{{ route('competence.index') }}"
                                    }, 1500)
                                }
                            })

                        }
                    });
            })
        });

    </script>
@endsection
