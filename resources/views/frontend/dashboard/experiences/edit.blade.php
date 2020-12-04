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
                            <form method="POST" action="{{ route('experience.update',[$exper->id]) }}">
                                @csrf
                                {{method_field('PUT')}}
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
                                            <label for="nama_alumni">Nama Alumni</label>
                                            <input type="text" readonly name="nama_alumni" class="form-control"
                                                value="{{ $user->name }}" id="nama_alumni">
                                        </div>
                                        <div class="form-group">
                                            <label for="lama_berkerja">Lama Bekerja</label>
                                            <input type="date" name="lama_berkerja" class="form-control"
                                                value="{{ $exper->start_date }}" id="lama_berkerja">
                                        </div>
                                        <div class="form-group">
                                            <label for="jabatan">Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control" value="{{$exper->job_title}}" id="jabatan">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_perusahaan">Nama Perusahaan</label>
                                            <input type="text" name="nama_perusahaan" class="form-control"
                                            value="{{$exper->company_name}}"  id="nama_perusahaan">
                                        </div>
                                        <div class="form-group">
                                            <label for="berhenti_bekerja">Sampai</label>
                                            <input type="date" @if($exper->end_date!==null) value="{{ $exper->end_date }}" @else disabled @endif name="berhenti_bekerja" class="form-control"
                                                id="berhenti_bekerja">
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" name="sekarang" class="form-check-input" @if($exper->is_present==1) checked @endif id="sekarang">
                                            <label class="form-check-label" for="sekarang">Sekarang</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" value="{{$exper->location}}" id="alamat">
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi</label>
                                        <textarea class="form-control" name="deskripsi" id="deskripsi">{{$exper->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
        });

    </script>
@endsection
