@foreach ($post_penyakit as $item)
    <!-- Modal -->
    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Post Penyakit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" action="{{ route('landingPagePostPenyakit.update', $item->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12" hidden>
                                <label class="form-label">User ID</label>
                                <input type="text" name="user_id"
                                    class="form-control @error('user_id') is-invalid @enderror"
                                    value="{{ Auth::id() }}" required>
                                @error('user_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Kategori Penyakit</label>
                                <select class="form-select @error('id_penyakit') is-invalid @enderror"
                                    name="id_penyakit" required>
                                    <option selected disabled value="">Pilih Penyakit</option>
                                    @foreach ($data_penyakit as $data)
                                        <option value="{{ $data->id }}"
                                            {{ $data->id == $item->id_penyakit ? 'selected' : '' }}>
                                            {{ $data->kode_penyakit }} - {{ $data->nama_penyakit }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_penyakit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Title</label>
                                <input type="text" name="title_post_penyakit" placeholder="Enter title"
                                    class="form-control @error('title_post_penyakit') is-invalid @enderror"
                                    value="{{ $item->title_post_penyakit }}" required>
                                @error('title_post_penyakit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Tags</label>
                                <input type="text" name="tags_post_penyakit" placeholder="Enter tags"
                                    class="form-control tags-edit-{{ $item->id }} @error('tags_post_penyakit') is-invalid @enderror"
                                    value="{{ $item->tags_post_penyakit }}" data-role="tagsinput">
                                @error('tags_post_penyakit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control @error('description_post_penyakit') is-invalid @enderror" name="description_post_penyakit"
                                    id="editor-edit-{{ $item->id }}" rows="3" placeholder="Enter description">{{ $item->description_post_penyakit }}</textarea>
                                @error('description_post_penyakit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Video</label>
                                <input type="text" name="video_post_penyakit" placeholder="Enter video"
                                    class="form-control" value="{{ $item->video_post_penyakit }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Image</label>
                                <input type="file" name="image_post_penyakit" placeholder="Enter image"
                                    class="form-control @error('image_post_penyakit') is-invalid @enderror">
                                @error('image_post_penyakit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="mt-2">
                                    @if ($item->image_post_penyakit)
                                        <img src="{{ Storage::url($item->image_post_penyakit) }}"
                                            alt="{{ $item->id }}" style="max-height: 200px;">
                                    @else
                                        <p>No image available</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
