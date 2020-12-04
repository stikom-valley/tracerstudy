@extends('frontend.master')

@section('title', 'Pengguna')

@section('experiences', 'class=active')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Riwayat Pekerjaan</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h4 class="text-dark"><i class="fas fa-list pr-2"></i> Buat Riwayat Pekerjaan</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('experience.store') }}">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pilih_alumni">Pilih Alumni</label>
                                            <select class="form-control pilih_alumni" name="pilih_alumni" id="pilih_alumni">
                                                @foreach ($users as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="lama_berkerja">Lama Bekerja</label>
                                            <input type="date" name="lama_berkerja" class="form-control" id="lama_berkerja">
                                        </div>
                                        <div class="form-group">
                                            <label for="jabatan">Jabatan</label>
                                            <input type="text" name="jabatan" class="form-control"
                                                id="jabatan">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_perusahaan">Nama Perusahaan</label>
                                            <input type="text" name="nama_perusahaan" class="form-control"
                                                id="nama_perusahaan">
                                        </div>
                                        <div class="form-group">
                                            <label for="berhenti_bekerja">Sampai</label>
                                            <input type="date" name="berhenti_bekerja" class="form-control"
                                                id="berhenti_bekerja">
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" name="sekarang" class="form-check-input" id="sekarang">
                                            <label class="form-check-label" for="sekarang">Sekarang</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" name="alamat" class="form-control" id="alamat">
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>

                            </form>
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

            $('.pilih_alumni').select2();

            function ajax() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }

            $('#sekarang').on('change', function() {

                var data = $(this).prop('checked');

                if (data == true) {
                    $('#berhenti_bekerja').attr('disabled', 'disabled');
                } else {
                    $('#berhenti_bekerja').removeAttr('disabled');
                }

            })
            // $(document).on('click', '.delete', function() {
            //     var id = $(this).data('id');
            //     swal({
            //             title: "Apa kamu yakin ?",
            //             text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
            //             icon: "warning",
            //             buttons: true,
            //             dangerMode: true,
            //         })
            //         .then((willDelete) => {
            //             if (willDelete) {
            //                 ajax();
            //                 $.ajax({
            //                     url: '{{ url('dashboard/experience') }}/' + id,
            //                     method: 'DELETE',
            //                     success: function(data) {
            //                         swal("Data berhasil dihapus", {
            //                             icon: "success",
            //                         });
            //                         setTimeout(function() {
            //                             window.location.href =
            //                                 "{{ route('experience.index') }}"
            //                         }, 1500)
            //                     }
            //                 })

            //             }
            //         });
            // })
        });

    </script>
@endsection
