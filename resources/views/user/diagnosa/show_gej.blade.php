@foreach ($gejalas as $item)
    <!-- Modal -->
    <div class="modal fade" id="show_gejala{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Tampilkan deskripsi gejala</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 w-full">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title my-3">{{ $item->nama_gejala }}</h5>
                                <p class="card-text my-3">{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
