@foreach($user as $pas => $pasien)
<div class="modal fade" id="edit_pasien{{ $pasien->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $pasien->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel{{ $pasien->id }}">Edit Data Pasien</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/datapasien', $pasien->id) }}" method="POST" id="formEdit">
                @method("PUT")
                @csrf
                <div class="modal-body row g-3" id="modal-content-edit">
                    <div class="col-md-12">
                        <label for="form-label" class="form-label">Nama Lengkap</label>
                        <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}{{ $pasien->name }}" placeholder="Masukan name">
                    
                        @error('name')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="form-label" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}{{ $pasien->email }}" placeholder="Masukan email">
                    
                        @error('email')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="form-label" class="form-label">Umur</label>
                        <input type="umur" name="umur" class="form-control @error('umur') is-invalid @enderror" value="{{ old('umur') }}{{ $pasien->umur }}" placeholder="Masukan umur">
                    
                        @error('umur')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" aria-label="Default select example">
                            <option value="" selected>- Pilih Jenis Kelamin -</option>
                            <option value="Perempuan" {{ $pasien->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            <option value="Laki-laki" {{ $pasien->jenis_kelamin === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        </select>
                    
                        @error('jenis_kelamin')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="4" placeholder="Masukkan alamat">{{ old('alamat') }}{{ $pasien->alamat }}</textarea>
                    
                        @error('alamat')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="form-label" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Masukan password baru">
                        @error('password')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
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