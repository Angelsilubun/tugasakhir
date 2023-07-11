@foreach ($data_penyakit as $data => $penyakit)
    <div class="modal fade" id="edit_penyakit{{ $penyakit->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel{{ $penyakit->id }}">Edit Data Penyakit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/pakar/datapenyakit', $penyakit->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body" id="modal-content-edit">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Kode Penyakit</label>
                                <input type="kode" name="kode_penyakit"
                                    class="form-control @error('kode_penyakit') is-invalid @enderror"
                                    value="{{ old('kode_penyakit') }}{{ $penyakit->kode_penyakit }}" required>
                                @error('kode_penyakit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Nama Penyakit</label>
                                <input type="nama" name="nama_penyakit"
                                    class="form-control @error('nama_penyakit') is-invalide @enderror"
                                    value="{{ old('nama_penyakit') }}{{ $penyakit->nama_penyakit }}" required>
                                @error('nama_penyakit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                                    id="editor-edit-{{ $penyakit->id }}" rows="3" placeholder="Enter description">{{ $penyakit->deskripsi }}</textarea>
                                @error('deskripsi')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
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
