@foreach ($user as $admin)
<input type="hidden" name="gambarLama" value="{{ $admin->image }}">
<div class="modal fade" id="edit_admin{{ $admin->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $admin->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel{{ $admin->id }}">Edit Data Admin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/dataadmin', $admin->id) }}" method="POST" enctype="multipart/form-data">
                @method("PUT")
                @csrf
                <div class="modal-body row g-3" id="modal-content-edit">
                    <div class="col-md-12">
                        <label for="form-label" class="form-label">Username</label>
                        <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}{{ $admin->name }}" placeholder="Masukan name">
                        @error('name')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="form-label" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}{{ $admin->email }}" placeholder="Masukan email">
                        @error('email')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="form-label" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukan password baru">
                        @error('password')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
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
                            @if ($admin->image)
                                <img src="{{ Storage::url($admin->image) }}" alt="{{ $admin->id }}"
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