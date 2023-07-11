@foreach ($data_petunjuk as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Petunjuk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" action="{{ route('petunjuk_penggunaan.update', $item->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul petunjuk</label>
                        <input type="text" name="judul_petunjuk"
                            class="form-control @error('judul_petunjuk') is-invalid @enderror"
                            id="judul_petunjuk" value="{{ $item->judul_petunjuk }}"
                            placeholder="Masukan judul petunjuk" required>
                    </div>
                    @error('judul_petunjuk')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="col-md-12">
                        <label class="form-label">Isi</label>
                        <textarea class="form-control @error('isi') is-invalid @enderror" name="isi"
                            id="editor-edit-{{ $item->id }}" rows="3" placeholder="Enter description">{{ $item->isi }}</textarea>
                        @error('isi')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" placeholder="Enter image"
                            class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            @if ($item->image)
                                <img src="{{ Storage::url($item->image) }}"
                                    alt="{{ $item->id }}" style="max-height: 200px;">
                            @else
                                <p>No image available</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach