<!-- Modal -->
<div class="modal fade" id="modalCompetence" tabindex="-1" role="dialog" aria-labelledby="modalCompetenceLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCompetenceLabel">Kompetensi Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{route('competence.store')}}" method="post">
                @csrf
                    <div class="form-group">
                        <label for="pilih_alumni">Pilih Alumni</label>
                        <select required class="form-control pilih_alumni" name="pilih_alumni" id="pilih_alumni">
                            @foreach ($users as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_kompetensi">Nama Kompetensi</label>
                        <input type="text" name="nama_kompetensi" required class="form-control" id="nama_kompetensi">
                    </div>
                    <div class="form-group">
                        <label for="sertifikat">Sertifikat Dokumen</label>
                        <input type="text" name="sertifikat" required class="form-control" id="sertifikat">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
