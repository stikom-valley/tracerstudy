@extends('frontend.master')

@section('title', 'Kuisioner')

@section('questions', 'class=active')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('question.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{!! $question->description !!}</h1>
        <div class="section-header-button ml-auto">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#create-answer-modal"><i
                    class="fas fa-plus pr-2"></i>Jawaban Baru</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h4 class="text-dark"><i class="fas fa-list pr-2"></i>Daftar Jawaban</h4>
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
                                    @foreach ($answers as $item)
                                    <tr>
                                        <td>{{ $item->description }}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-info">
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
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="text-primary"><i class="fas fa-plus pr-2"></i> Pertanyaan Baru</h4>
                    </div>
                    <form action="{{ route('question.update', $question->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <textarea name="description"
                                class="summernote-simple">{!! $question->description !!}</textarea>
                            @error('description')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fas fa-save pr-2"></i>Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend.dashboard.answers.create')
@endsection

@section('scripts')
    <script type="text/javascript">
    $(document).ready(function(){
        $("#table-1").dataTable();
    
        $('#btn-save-answer').click(function (e) {
            e.preventDefault();
            var form = $('#form-create-answer');

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

        $('#btn-cancel-save-answer').click(function (e) {
            var form = $('#form-create-answer');
            form.find('.message').html('');
            $("#description").val('');
        });
    });
    </script>
@endsection