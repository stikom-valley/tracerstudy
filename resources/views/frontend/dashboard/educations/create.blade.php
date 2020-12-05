@extends('frontend.master')

@section('title', 'Kelulusan')

@section('educations', 'class=active')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('education.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Kelulusan</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="text-primary"><i class="fas fa-plus pr-2"></i> Kelulusan Baru</h4>
                    </div>
                    <form action="{{ route('education.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="user_id">Alumni <span class="text-danger">*</span></label>
                                        <select name="user_id" class="form-control select2"
                                            data-placeholder="Pilih Alumni">
                                            <option></option>
                                            @foreach ($users as $item)
                                            <option value="{{ $item->id }}" {{ old('user_id') == $item->id ? 'selected':'' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">
                                            Tambahkan data <b>Pengguna</b> jika tidak ada nama Alumni yang dicari
                                        </small>
                                        @error('user_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="faculty_id">Fakultas <span class="text-danger">*</span></label>
                                        <select name="faculty_id" id="faculty_id" class="form-control select2"
                                            data-placeholder="Pilih Fakultas">
                                            <option></option>
                                            @foreach ($faculties as $item)
                                            <option value="{{ $item->id }}" {{ old('faculty_id') == $item->id ? 'selected':'' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('faculty_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="major_id">Jurusan <span class="text-danger">*</span></label>
                                        <select name="major_id" id="major_id" class="form-control select2"
                                            data-placeholder="Pilih Jurusan">
                                            <option></option>
                                        </select>
                                        @error('major_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="daterange">Tahun Masuk hingga Lulus <span class="text-danger">*</span></label>
                                        <input type="text" name="daterange" class="form-control datepicker-cus" value="{{ old('daterange') }}">
                                        @error('daterange')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="score">IPK <span class="text-danger">*</span></label>
                                        <input type="number" name="score" class="form-control" min="1" max="4" step="0.01" placeholder="Masukkan IPK...">
                                        @error('score')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fas fa-save pr-2"></i>Simpan</button>
                        </div>
                    </form>
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
        $(".select2").select2();
        $('.datepicker-cus').daterangepicker({
            locale: {format: 'DD-MM-YYYY'},
            drops: 'down',
            opens: 'left',
            showDropdowns: true,
        });
        $('#faculty_id').change(function () {
            var id = $(this).val();

            $.ajax({
                    url: "{{ route('get.major') }}?faculty_id=" + id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function (response) {
                    if(response.status == true){
                        $('#major_id').empty();
                        $('#major_id').append('<option></option>');
                        $.each(response.data, function (key, value) {
                            $('#major_id').append('<option value="' + value.id + '">' + value
                                .name + '</option>')
                        });
                    }
                });
        });
    });

</script>
@endsection