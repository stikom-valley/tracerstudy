<!-- Modal -->
<div class="modal fade" id="create-major-modal" tabindex="-1" role="dialog"
    aria-labelledby="create-major-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="create-major-modalLabel"><i
                        class="fas fa-plus pr-2"></i>Jurusan Baru</h5>
            </div>
            <form action="{{route('major.store')}}" method="post" id="form-create-major">
                @csrf
                <input type="hidden" name="faculty_id" value="{{ $faculty->id }}" readonly>
                <div class="modal-body">
                    <div class="message"></div>
                    <div class="form-group">
                        <label for="name">Nama Jurusan <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-cancel-save-major" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-save-major" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>