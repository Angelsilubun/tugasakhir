@extends('layouts_admin.main')

@section('title', 'Penyakit')

@section('container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="mb-2">Data Artikel Post Penyakit</h1>
            @if (session('success'))
                <script>
                    showSuccessToast("{{ session('success') }}");
                </script>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('gagal'))
                <script>
                    showErrorToast("{{ session('gagal') }}");
                </script>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('gagal') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            <script>
                                showErrorToast("{{ $error }}");
                            </script>
                        @endforeach

                    </ul>
                </div>
            @endif
        </div>

        <section class="section profile">
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-grid gap-2 d-md-flex justify-content-md mt-3 mb-3">
                                    <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#tambah"><i class="bi bi-plus-circle"></i> Tambah</button>
                                </div>

                                <!-- Default Table -->
                                <div class="table-responsive">
                                    <table class="table mt-3 table-hover align-middle" id="dataTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" class="text-nowrap">No</th>
                                                <th scope="col" class="text-nowrap">Image</th>
                                                <th scope="col" class="text-nowrap">Penyakit</th>
                                                <th scope="col" class="text-nowrap">Title</th>
                                                {{-- <th scope="col" class="text-nowrap">Description</th> --}}
                                                <th scope="col" class="text-nowrap">Tags</th>
                                                {{-- <th scope="col" class="text-nowrap">Video</th> --}}
                                                <th scope="col" class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($post_penyakit as $data => $penyakit)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src="{{ Storage::url($penyakit->image_post_penyakit) }}"
                                                            alt="{{ $penyakit->id }}" width="75" class="rounded">
                                                    </td>
                                                    <td>{{ $penyakit->penyakit->nama_penyakit }}</td>
                                                    <td class="text-nowrap">{{ $penyakit->title_post_penyakit }}</td>
                                                    {{-- <td>
                                                        {!! Str::limit($penyakit->description_post_penyakit, 50, '...') !!}
                                                    </td> --}}
                                                    <td>
                                                        @php
                                                            $tags = json_decode($penyakit->tags_post_penyakit, true);
                                                        @endphp

                                                        @if (is_array($tags))
                                                            @foreach ($tags as $tag)
                                                                <span class="badge bg-primary">{{ $tag['value'] }}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    {{-- <td>{{ $penyakit->video_post_penyakit }}</td> --}}

                                                    <td>
                                                        <div class="btn-group d-flex btn-group-sm">
                                                            <button type="button"
                                                                class="btn text-light btn-sm mx-1" style="background-color: #009999"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#showModal{{ $penyakit->id }}">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-primary text-light btn-sm mx-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal{{ $penyakit->id }}">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </button>
                                                            <form onsubmit="return confirm('Apakah anda yakin?');"
                                                                action="{{ route('landingPagePostPenyakit.destroy', $penyakit->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger text-light btn-sm mx-1">
                                                                    <i class="bi bi-trash3-fill"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- {!! $data_penyakit->withQueryString()->links('pagination::bootstrap-5') !!} --}}
                            </div>

                        </div>
                    </div>
                </div>
            </section>

            @include('pakar.artikel.penyakit.edit')
            @include('pakar.artikel.penyakit.show')

            <!-- Modal -->
            <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Post Penyakit</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="needs-validation" action="{{ route('landingPagePostPenyakit.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
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
                                            @foreach ($data_penyakit as $item)
                                                <option value="{{ $item->id }}">{{ $item->kode_penyakit }} -
                                                    {{ $item->nama_penyakit }}
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
                                            value="{{ old('title_post_penyakit') }}" required>
                                        @error('title_post_penyakit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Tags</label>
                                        <input type="text" name="tags_post_penyakit" placeholder="Enter tags"
                                            class="form-control tags-tambah @error('tags_post_penyakit') is-invalid @enderror"
                                            value="{{ old('tags_post_penyakit') }}" data-role="tagsinput">
                                        @error('tags_post_penyakit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control @error('description_post_penyakit') is-invalid @enderror"
                                            name="description_post_penyakit" id="editor" rows="3" placeholder="Enter description">{{ old('description_post_penyakit') }}</textarea>
                                        @error('description_post_penyakit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Video</label>
                                        <input type="text" name="video_post_penyakit" placeholder="Enter video"
                                            class="form-control @error('video_post_penyakit') is-invalid @enderror"
                                            value="{{ old('video_post_penyakit') }}">
                                        @error('video_post_penyakit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="image_post_penyakit" placeholder="Enter image"
                                            class="form-control @error('image_post_penyakit') is-invalid @enderror"
                                            required>
                                        @error('image_post_penyakit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                <button type="button" class="btn btn-danger btn-sm"
                                    data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </section>
    </main>



@section('js')

    @foreach ($post_penyakit as $item)
        <script>
            ClassicEditor
                .create(document.querySelector('#editor-edit-{{ $item->id }}'))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
        <script>
            var input = document.querySelector('.tags-edit-{{ $item->id }}');
            new Tagify(input);
        </script>
    @endforeach

    <script>
        // Tambahkan event listener untuk event submit form
        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('.needs-validation');

            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Mencegah form untuk melakukan submit

                    // Ambil nilai input video_post_penyakit
                    var videoInput = form.querySelector('input[name="video_post_penyakit"]');
                    var videoUrl = videoInput.value;

                    // Cek apakah URL YouTube
                    if (videoUrl.includes('youtube.com')) {
                        // Ubah URL menjadi bentuk embed
                        var videoId = getYouTubeVideoId(videoUrl);
                        var embedUrl = 'https://www.youtube.com/embed/' + videoId;

                        // Ganti nilai input dengan URL embed
                        videoInput.value = embedUrl;
                    }

                    // Submit form
                    form.submit();
                });
            });
        });

        // Fungsi untuk mendapatkan video ID dari URL YouTube
        function getYouTubeVideoId(url) {
            var videoId = '';
            var pattern = /(?:[?&](?:v|embed)=|\/embed\/|youtu\.be\/|\/v\/|\/e\/|\/watch\?v=|\/watch\?.+&v=)([^&]{11})/i;
            var match = url.match(pattern);

            if (match) {
                videoId = match[1];
            }

            return videoId;
        }
    </script>


    <script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        var input = document.querySelector('.tags-tambah');
        new Tagify(input);
    </script>


    <script>
        function showSuccessToast(message) {
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                    type: 'success',
                    background: '#4caf50',
                    icon: {
                        className: 'bi bi-check',
                        tagName: 'i',
                        color: '#ffffff'
                    },
                    dismissible: true,
                    duration: 3000,
                    ripple: true
                }]
            });
            notyf.success(message);
        }

        function showErrorToast(message) {
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                    type: 'error',
                    background: '#f44336',
                    icon: {
                        className: 'bi bi-x',
                        tagName: 'i',
                        color: '#ffffff'
                    },
                    dismissible: true,
                    duration: 3000,
                    ripple: true
                }]
            });
            notyf.error(message);
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (document.querySelector('.alert-success')) {
                const successMessage = document.querySelector('.alert-success strong').textContent;
                showSuccessToast(successMessage);
            }

            if (document.querySelector('.alert-danger')) {
                const errorMessage = document.querySelector('.alert-danger strong').textContent;
                showErrorToast(errorMessage);
            }
        });
    </script>

@endsection
@endsection
