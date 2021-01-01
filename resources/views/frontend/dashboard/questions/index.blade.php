@extends('frontend.master')

@section('title', 'Kuisioner')

@section('questions', 'class=active')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Kuisioner</h1>
        <div class="section-header-button ml-auto">
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#show-sort-modal"><i
                class="fas fa-sort pr-2"></i>Urutan</a>
            <a href="{{ route('question.create') }}" class="btn btn-primary"><i
                    class="fas fa-plus pr-2"></i>Pertanyaan Baru</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h4 class="text-dark"><i class="fas fa-list pr-2"></i> Daftar Pertanyaan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Pertanyaan</th>
                                        <th>Tipe Pertanyaan</th>
                                        <th>Tipe Jawaban</th>
                                        <th width="15%">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $item)
                                    <tr>
                                        <td>{!! $item->description !!}</td>
                                        <td>
                                            @if ($item->type_question == 'BOT')
                                                <span class="badge badge-primary">BOT</span>
                                                @else
                                                <span class="badge badge-success">KUISIONER</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->type_answer == 'ESSAY')
                                                <span class="badge badge-warning">ESSAY</span>
                                                @else
                                                <span class="badge badge-info">PILIHAN</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('question.show', [$item->id]) }}"
                                                class="btn btn-sm btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('question.edit', $item->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" data-id="{{$item->id}}" class="btn delete btn-sm btn-danger">
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
@include('frontend.dashboard.questions.sort')
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

        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1
        }).on('change', updateOutput);
        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));
    //sorting link list
    $('.dd').on('change', function () {
        var t = $(this);
        var serializedData = $(t).nestable('serialize');
        ajax();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('question.sort') }}",
            data: {
                sequence: serializedData
            }
        });
    });
    });

</script>
@endsection
