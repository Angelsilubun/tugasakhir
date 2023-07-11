@foreach ($data_petunjuk as $item)
    <!-- Modal -->
    <div class="modal fade" id="showModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">{{ $item->judul_petunjuk }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 w-full">
                        <div class="card">
                            <img src="{{ Storage::url($item->image) }}" class="card-img-top"
                                alt="{{ $item->id }}">
                            <div class="card-body">
                                <h5 class="card-title my-3">{{ $item->judul_petunjuk }}</h5>
                                <p class="card-text my-3">{!! $item->isi !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
