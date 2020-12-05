<!-- Modal -->
<div class="modal fade" id="show-sort-modal" tabindex="-1" role="dialog" aria-labelledby="show-sort-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="show-sort-modalLabel"><i
                        class="fas fa-sort pr-2"></i>Urutan Pertanyaan</h5>
            </div>
            <div class="modal-body">
                <div class="dd" id="nestable">
                    <ol class="dd-list">
                        @forelse ($questions as $item)
                            <li class="dd-item" data-id="{{ $item->id }}">
                                <div class="dd-handle btn btn-light btn-block">
                                    {!! $item->description !!}
                                </div>
                            </li>
                        @empty
                            Maaf, anda belum membuat <b>Pertanyaan</b>!
                        @endforelse
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>