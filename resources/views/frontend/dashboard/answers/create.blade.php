<!-- Modal -->
<div class="modal fade" id="create-answer-modal" tabindex="-1" role="dialog"
    aria-labelledby="create-answer-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="create-answer-modalLabel"><i
                        class="fas fa-plus pr-2"></i>Jawaban Baru</h5>
            </div>
            <form action="{{route('answer.store')}}" method="post" id="form-create-answer">
                @csrf
                <input type="hidden" name="question_id" value="{{ $question->id }}" readonly>
                <div class="modal-body">
                    <div class="message"></div>
                    <div class="form-group">
                        <label for="description">Deskripsi <span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control" id="description" value="{{ old('description') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-cancel-save-answer" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-save-answer" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>