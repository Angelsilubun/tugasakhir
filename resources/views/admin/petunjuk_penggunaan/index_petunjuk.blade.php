@extends('layouts_admin.main')

@section('title', 'Tentang')

@section('container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="mb-2">Data Petunjuk Penggunaan</h1>
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
                                <div
                                    class="d-grid gap-2 d-md-flex justify-content-md-start justify-content-start mt-3 mb-3">
                                    <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#tambah_tentang">
                                        <i class="bi bi-plus-circle"></i> Tambah
                                    </button>
                                </div>

                                <!-- Default Table -->
                                <div class="table-responsive">
                                    <table class="table mt-3 table-hover align-middle" id="dataTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" class="text-nowrap">No</th>
                                                <th scope="col" class="text-nowrap">Judul Petunjuk</th>
                                                <th scope="col" class="text-nowrap">Isi</th>
                                                <th scope="col" class="text-nowrap">Gambar</th>
                                                <th scope="col" class="text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_petunjuk as $data => $petunjuk)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $petunjuk->judul_petunjuk }}</td>
                                                    <td>{!! \Illuminate\Support\Str::limit($petunjuk->isi, 75) !!}</td>
                                                    <td>
                                                        <img src="{{ Storage::url($petunjuk->image) }}"
                                                            alt="{{ $petunjuk->id }}" width="50" class="rounded">
                                                    </td>
                                                    <td>
                                                        <div class="btn-group d-flex btn-group-sm">
                                                            <button type="button" class="btn text-light btn-sm mx-1" style="background-color: #009999"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#showModal{{ $petunjuk->id }}">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-primary text-light btn-sm mx-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal{{ $petunjuk->id }}">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </button>
                                                            <form onsubmit="return confirm('Apakah anda yakin?');"
                                                                action="{{ route('petunjuk_penggunaan.destroy', $petunjuk->id) }}"
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

                                {{-- {!! $data_tentang->withQueryString()->links('pagination::bootstrap-5') !!} --}}
                            </div>

                        </div>
                    </div>
                </div>
            </section>

            @include('admin.petunjuk_penggunaan.show_petunjuk')
            @include('admin.petunjuk_penggunaan.edit_petunjuk')

            <!-- Modal -->
            <div class="modal fade" id="tambah_tentang" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Tentang</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="needs-validation" action="{{ route('petunjuk_penggunaan.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label class="form-label">Judul petunjuk</label>
                                    <input type="judul" name="judul_petunjuk"
                                        class="form-control @error('judul_petunjuk') is-invalid @enderror"
                                        id="judul_petunjuk" value="{{ old('judul_petunjuk') }}"
                                        placeholder="Masukan judul petunjuk" required>
                                </div>
                                @error('judul_petunjuk')
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="col-md-12">
                                    <label class="form-label">isi</label>
                                    <textarea class="form-control @error('isi') is-invalid @enderror" name="isi" id="editor" rows="3"
                                        placeholder="Enter isi">{{ old('isi') }}</textarea>
                                    @error('isi')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="image" placeholder="Enter image"
                                        class="form-control @error('image') is-invalid @enderror" required>
                                    @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
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

    {{-- <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
    </script>

    <script>
        function disable1(button) {
            button.disabled = true;
            var buttonText = document.getElementById("buttonText");
            buttonText.textContent = "Tunggu...";

            setTimeout(function() {
                button.form.submit();
            }, 500);
        }
    </script> --}}
@endsection

@section('js')

    <script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "lengthMenu": [5, 10, 25, 50] // Menampilkan opsi untuk menampilkan 5, 10, 25, atau 50 data
            });
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

    @foreach ($data_petunjuk as $item)
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
    @endforeach

@endsection
