@foreach ($data_gejala as $gejala)
    <div class="modal fade" id="edit_gejala{{ $gejala->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel{{ $gejala->id }}">Edit Data Gejala</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/pakar/datagejala', $gejala->id) }}" method="POST" id="formEdit">
                    @method('PUT')
                    @csrf
                    <div class="modal-body" id="modal-content-edit">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Kode Gejala</label>
                                <input type="kode" name="kode_gejala"
                                    class="form-control @error('kode_gejala') is-invalid @enderror"
                                    value="{{ old('kode_gejala') }}{{ $gejala->kode_gejala }}" required>
                                @error('kode_gejala')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="col-md-12">
                                <label class="form-label">Nama Gejala</label>
                                <input type="nama" name="nama_gejala"
                                    class="form-control @error('nama_gejala') is-invalide @enderror"
                                    value="{{ old('nama_gejala') }}{{ $gejala->nama_gejala }}" required>
                                @error('nama_gejala')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label">Nama gejala</label>
                                <textarea class="form-control @error('nama_gejala') is-invalid @enderror" name="nama_gejala" rows="3"
                                    placeholder="Enter nama gejala" required>{{ $gejala->nama_gejala }}</textarea>
                                @error('nama_gejala')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="col-md-12">
                                <label class="form-label">Nama gejala</label>
                                <input type="nama" name="nama_gejala"
                                    class="form-control @error('nama_gejala') is-invalid @enderror"
                                    value="{{ old('nama_gejala') }}" required>
                                @error('nama_gejala')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Gejala</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="3"
                                    placeholder="Enter deskripsi" required>{{ $gejala->deskripsi }}</textarea>
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
