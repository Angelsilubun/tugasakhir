@extends('layouts_admin.main')

@section('title', 'Penyakit')

@section('container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="mb-2">Data Penyakit</h1>
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
                                        data-bs-target="#tambah_penyakit">
                                        <i class="bi bi-plus-circle"></i> Tambah
                                    </button>
                                </div>

                                <!-- Default Table -->
                                <div class="table-responsive">
                                    <table class="table mt-3 table-hover align-middle" id="dataTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" class="text-nowrap">No</th>
                                                <th scope="col" class="text-nowrap">Kode Penyakit</th>
                                                <th scope="col" class="text-nowrap">Nama Penyakit</th>
                                                <th scope="col" class="text-nowrap">Deskripsi</th>
                                                <th scope="col" class="text-nowrap w-25">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_penyakit as $data => $penyakit)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $penyakit->kode_penyakit }}</td>
                                                    <td>{{ $penyakit->nama_penyakit }}</td>
                                                    <td>{!! \Illuminate\Support\Str::limit($penyakit->deskripsi, 80) !!}</td>
                                                    <td>
                                                        <div class="btn-group d-flex btn-group-sm">
                                                            <form onsubmit="return confirm('Apakah anda yakin?');"
                                                                action="{{ route('datapenyakit.destroy', $penyakit->id) }}"
                                                                method="POST">
                                                                <button type="button"
                                                                    class="btn btn-primary text-light btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#edit_penyakit{{ $penyakit->id }}">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </button>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger text-light btn-sm">
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

            @include('admin.datapenyakit.edit')

            <!-- Modal -->
            <div class="modal fade" id="tambah_penyakit" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Penyakit</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/pakar/datapenyakit') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Kode Penyakit</label>
                                        <input type="kode" name="kode_penyakit"
                                            class="form-control @error('kode_penyakit') is-invalid @enderror"
                                            value="{{ old('kode_penyakit') }}" required>
                                        @error('kode_penyakit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Nama Penyakit</label>
                                        <input type="nama" name="nama_penyakit"
                                            class="form-control @error('nama_penyakit') is-invalide @enderror"
                                            value="{{ old('nama_penyakit') }}" required>
                                        @error('nama_penyakit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="editor" rows="3"
                                            placeholder="Enter deskripsi">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('js')

    {{-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> --}}
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

    @foreach ($data_penyakit as $item)
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
