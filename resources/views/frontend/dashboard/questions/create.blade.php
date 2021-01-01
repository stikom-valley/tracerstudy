@extends('frontend.master')

@section('title', 'Kuisioner')

@section('questions', 'class=active')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('question.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Kuisioner</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="text-primary"><i class="fas fa-plus pr-2"></i> Pertanyaan Baru</h4>
                        </div>
                        <form action="{{ route('question.store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="type_questions">Tipe Pertanyaan <span class="text-danger">*</span></label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="type_questions" value="BOT"
                                                class="selectgroup-input type_questions">
                                            <span class="selectgroup-button"><i class="fas fa-robot pr-2"></i> BOT</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="type_questions" value="GENERAL"
                                                class="selectgroup-input type_questions">
                                            <span class="selectgroup-button"><i class="fas fa-list-ol pr-2"></i>
                                                KUISIONER</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group type_answer">
                                    <label for="type_answers">Tipe Jawaban <span class="text-danger">*</span></label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="type_answers" value="ESSAY"
                                                class="selectgroup-input type_answers_input">
                                            <span class="selectgroup-button"><i class="fas fa-align-left pr-2"></i>
                                                ESSAY</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="type_answers" value="CHOICE"
                                                class="selectgroup-input type_answers_input">
                                            <span class="selectgroup-button"><i class="fas fa-check pr-2"></i>
                                                PILIHAN</span>
                                        </label>
                                    </div>
                                </div>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="form-group">
                                    <label for="description">Deskripsi <span class="text-danger">*</span></label>
                                    <small class="form-text text-muted">Minimal 10 karakter</small>
                                    <textarea name="description" required class="summernote-simple">{{ old('description') }}
                                    </textarea>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-success add_answer"><i
                                            class="fas fa-plus pr-2"></i>Jawaban</button>
                                </div>
                                <div class="answer_choice_list">
                                    <div class="form-group type_answer_choice">
                                        <label for="type_answer_choices">Jawaban 1 <span
                                                class="text-danger">*</span></label>
                                        <small class="form-text text-muted">Minimal 5 karakter</small>
                                        <input type="hidden" value="1">
                                        <textarea name="description_choice[]" required class="summernote-simple">
                                                    </textarea>
                                    </div>
                                    <div class="form-group type_answer_choice">
                                        <label for="type_answer_choices">Jawaban 2 <span
                                                class="text-danger">*</span></label>
                                        <small class="form-text text-muted">Minimal 5 karakter</small>
                                        <input type="hidden" value="2">
                                        <textarea name="description_choice[]" required class="summernote-simple">
                                                    </textarea>
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
    <script>
        $(document).ready(function() {
            $('.type_answer').hide();
            $('.type_answer_choice').hide();
            $('.add_answer').hide();

            $('.type_questions').change(function() {
                var type = $(this).val();

                if (type == 'BOT') {
                    $('.type_answer').hide();
                } else if (type == 'GENERAL') {
                    $('.type_answer').show();
                }
            });


            $('.type_answers_input').change(function() {
                var type = $(this).val();
                if (type == 'CHOICE') {
                    $('.add_answer').show();
                    $('.type_answer_choice').show();
                } else {
                    $('.add_answer').hide();
                    $('.type_answer_choice').hide();
                }
            })
            var data = 0;
            $('.answer_choice_list').find('input:hidden').each(function() {
                var valinput = $(this).val();
                if (valinput != undefined || valinput != null) {
                    data = valinput;
                }
            });

            $('.add_answer').click(function() {
                var setdata = parseInt(data) + 1;
                $('.answer_choice_list').append(' <div class="form-group type_answer_choice">' +
                    '<label for="type_answer_choices">Jawaban ' + setdata +
                    '<span class="text-danger"> *</span></label>' +
                    '<small class="form-text text-muted">Minimal 5 karakter</small>' +
                    '<input type="hidden"  value="' + setdata + '">' +
                    '<textarea name="description_choice[]" class="summernote-simple">' +
                    '</textarea>' +
                    '</div>');
                $('.summernote-simple').summernote({
                    toolbar: [

                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough']],
                        ['para', ['paragraph']]
                    ]

                });
                data = setdata;
            })


        });

    </script>
@endsection
