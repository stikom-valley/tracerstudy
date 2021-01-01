@extends('frontend.master')

@section('title', 'Kuisioner')

@section('questions', 'class=active')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('question.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <p>{!! $question->description !!}</p>
            @if ($question->type_answer == 'CHOICE')
                <div class="section-header-button ml-auto">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#create-choice-modal"><i
                            class="fas fa-plus pr-2"></i>Pilihan Baru</a>
                </div>
            @endif
        </div>
        <div class="section-body">
            @if ($question->type_answer == 'CHOICE')
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-dark">
                            <div class="card-header">
                                <h4 class="text-dark"><i class="fas fa-list pr-2"></i>Daftar Pilihan</h4>
                            </div>
                            <div class="card-body">
                                <div class="text-right mb-2">
                                    <button type="button" data-question="{{$question->id}}" class="btn btn-warning deletebyquestion"><i
                                            class="fas fa-trash pr-2"></i>Hapus Semua Jawaban</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th width="15%">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($choices as $item)
                                                <tr>
                                                    <td>{{ $item->description }}</td>
                                                    <td class="text-center">
                                                        <a href="#" data-id="{{ $item->id }}"
                                                            class="btn delete btn-sm btn-danger">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                        <a href="#" data-id="{{ $item->id }}"
                                                            class="btn delete btn-sm btn-info">
                                                            <i class="fas fa-edit"></i>
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
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h4 class="text-info"><i class="fas fa-edit pr-2"></i> Edit Pertanyaan</h4>
                        </div>
                        <form action="{{ route('question.update', $question->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <textarea name="description"
                                    class="summernote-simple">{!!  $question->description !!}</textarea>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-block btn-info"><i
                                        class="fas fa-save pr-2"></i>Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('frontend.dashboard.choices.create')
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
                                url: "{{ url('dashboard/choice') }}/" + id,
                                method: 'DELETE',
                                success: function(data) {
                                    if (data['status'] == true) {
                                        swal(data['message'], {
                                            icon: "success",
                                        });
                                        setTimeout(function() {
                                            window.location.href =
                                                "{{ route('question.index') }}"
                                        }, 1500);
                                    } else if (data['status'] == false) {
                                        swal(data['message'], {
                                            icon: "error",
                                        });
                                    }

                                }
                            })

                        }
                    });
            });
            $(document).on('click', '.deletebyquestion', function () {
        var id = $(this).data('question');
        console.log(id);
        swal({
                title: "Apa kamu yakin ?",
                text: "Setelah dihapus mengapus semua jawaban ini, Anda tidak akan dapat memulihkan data ini!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    ajax();
                    $.ajax({
                        url: '{{ url("dashboard/choice/allchoice")}}/' + id,
                        method: 'DELETE',
                        success: function (data) {
                            if(data['status']==true){
                                swal(data['message'], {
                                icon: "success",
                              });
                              setTimeout(function(){window.location.href="{{route('question.index')}}"},1500);
                            }else if(data['status']==false){
                                swal(data['message'], {
                                icon: "error",
                              });
                            }

                        }
                    })

                }
            });
    });
            $('#btn-save-choice').click(function(e) {
                e.preventDefault();
                var form = $('#form-create-choice');

                $.ajax({
                        method: 'POST',
                        dataType: 'json',
                        url: form.attr('action'),
                        data: form.serialize()
                    })
                    .done(function(response) {
                        form.find('.message').html(response.message);

                        if (response.status == true) {
                            location.reload(true);
                        }
                    })
                    .fail(function(response) {
                        form.find('.message').html(
                            '<div class="alert alert-warning" role="alert">Ada yang salah, silahkan muat ulang laman ini </div>'
                        );
                    });
            });

            $('#btn-cancel-save-choice').click(function(e) {
                var form = $('#form-create-choice');
                form.find('.message').html('');
                $("#description").val('');
            });
        });

    </script>
@endsection
