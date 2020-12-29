<!-- Modal -->
<div class="modal fade" id="create-choice-modal" tabindex="-1" role="dialog"
    aria-labelledby="create-choice-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="create-choice-modalLabel"><i
                        class="fas fa-plus pr-2"></i>Pilihan Baru</h5>
            </div>
            <form action="{{route('choice.store')}}" method="post" id="form-create-choice">
                @csrf
                <input type="hidden" name="question_id" value="{{ $question->id }}" readonly>
                <div class="modal-body">
                    <div class="message"></div>
                    <div class="form-group">
                        <label for="description">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="description" rows="10" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-cancel-save-choice" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-save-choice" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>