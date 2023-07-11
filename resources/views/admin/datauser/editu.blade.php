@foreach ($user as $pakar)
    <input type="hidden" name="gambarLama" value="{{ $pakar->image }}">
    <div class="modal fade" id="edit_pakar{{ $pakar->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel{{ $pakar->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel{{ $pakar->id }}">Edit Data Pakar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/admin/datauser', $pakar->id) }}" method="POST" enctype="multipart/form-data"
                    id="formEdit">
                    @method('PUT')
                    @csrf
                    <div class="modal-body row g-3" id="modal-content-edit">
                        <div class="col-md-12">
                            <label for="form-label" class="form-label">Username</label>
                            <input type="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}{{ $pakar->name }}" placeholder="Masukan name">
                            @error('name')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="form-label" class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}{{ $pakar->email }}" placeholder="Masukan email">
                            @error('email')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="form-label" class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                value="{{ old('password') }}" placeholder="Masukan password baru">
                            @error('password')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <img src="{{ url('/storage/'.$pakar->image) }}" style="width: 50%" class="mb-4"> --}}

                        <div class="col-md-12">

                            <label class="form-label">Upload Gambar</label><br>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                name="image">

                            @error('image')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="mt-2">
                                @if ($pakar->image)
                                    <img src="{{ Storage::url($pakar->image) }}" alt="{{ $pakar->id }}"
                                        style="max-width: 25%;">
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
