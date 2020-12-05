<!-- Modal -->
<div class="modal fade" id="create-faculty-modal" tabindex="-1" role="dialog"
    aria-labelledby="create-faculty-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="create-faculty-modalLabel"><i
                        class="fas fa-plus pr-2"></i>Fakultas Baru</h5>
            </div>
            <form action="{{route('faculty.store')}}" method="post" id="form-create-faculty">
                @csrf
                <div class="modal-body">
                    <div class="message"></div>
                    <div class="form-group">
                        <label for="name">Nama Fakultas <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-cancel-save-faculty" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-save-faculty" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>