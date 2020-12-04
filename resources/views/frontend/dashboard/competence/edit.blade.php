<!-- Modal -->
<div class="modal fade" id="modalCompetence" tabindex="-1" role="dialog" aria-labelledby="modalCompetenceLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCompetenceLabel">Edit Kompetensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="formEdit" method="post">
                    {{ method_field('PUT') }}
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label for="nama_alumni">Nama Alumni</label>
                        <input type="text" name="nama_alumni" readonly class="form-control" id="nama_alumni">
                    </div>
                    <div class="form-group">
                        <label for="nama_kompetensi">Nama Kompetensi</label>
                        <input type="text" name="nama_kompetensi" required class="form-control" id="nama_kompetensi">
                    </div>
                    <div class="form-group">
                        <label for="sertifikat">Sertifikat Dokumen</label>
                        <input type="text" name="sertifikat" class="form-control" id="sertifikat">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn update btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
