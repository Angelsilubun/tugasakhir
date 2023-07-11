@extends('layouts_admin.main')

@section('title', 'Data Pasien')

@section('container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="mb-2">Data Pasien</h1>
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
                                        data-bs-target="#tambah_pasien"><i class="bi bi-plus-circle"></i> Tambah</button>
                                </div>

                                <!-- Default Table -->
                                <table class="table mt-4 table-hover align-middle" id="dataTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Lengkap</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Jenis Kelamin</th>
                                            <th scope="col">Umur</th>
                                            <th scope="col">Alamat</th>
                                            {{-- <th scope="col">Role</th> --}}
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $pas => $pasien)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $pasien->name }}</td>
                                                <td>{{ $pasien->email }}</td>
                                                <td>{{ $pasien->jenis_kelamin }}</td>
                                                <td>{{ $pasien->umur }}</td>
                                                <td>{{ $pasien->alamat }}</td>
                                                {{-- <td>{{ $pasien->role }}</td> --}}
                                                <td>
                                                    <form onsubmit="return confirm('Apakah anda yakin?');"
                                                        action="{{ route('datapasien.destroy', $pasien->id) }}"
                                                        method="POST">
                                                        <button type="button" class="btn btn-primary text-light btn-sm"
                                                            data-bs-toggle="modal" href="#edit_pasien{{ $pasien->id }}">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger text-light btn-sm">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </section>

            @include('admin.datapasien.editp')

            <!-- Modal -->
            <div class="modal fade" id="tambah_pasien" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Pasien</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/admin/datapasien') }}" method="POST">
                            @csrf
                            <div class="modal-body row g-2">
                                <div class="col-md-12">
                                    <label for="form-label" class="form-label">Nama Lengkap</label>
                                    <input type="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        value="{{ old('name') }}" placeholder="Masukan name">

                                    @error('name')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="form-label" class="form-label">Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" id="email"
                                        value="{{ old('email') }}" placeholder="Masukan email">

                                    @error('email')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="form-label" class="form-label">Umur</label>
                                    <input type="umur" name="umur"
                                        class="form-control @error('umur') is-invalid @enderror" id="umur"
                                        value="{{ old('umur') }}" placeholder="Masukan umur">

                                    @error('umur')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select" aria-label="Default select example"
                                        id="jenis_kelamin">
                                        <option value="" selected>- Pilih Jenis Kelamin -</option>
                                        <option value="Perempuan">Perempuan</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                    </select>

                                    @error('jenis_kelamin')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" rows="4"
                                        placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>

                                    @error('alamat')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="form-label" class="form-label">Password</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        value="{{ old('password') }}" placeholder="Masukan password">

                                    @error('password')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-sm"
                                    onclick="validateForm()">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('js')
    <script>
        function validateForm() {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var jenis_kelamin = document.getElementById('jenis_kelamin').value;
            var umur = document.getElementById('umur').value;
            var alamat = document.getElementById('alamat').value;

            if (name.trim() === '' || email.trim() === '' || password.trim() === '' || jenis_kelamin.trim() === '' || umur
                .trim() === '' || alamat.trim() === '') {
                alert('Data tidak boleh kosong');
                return false; // Prevent form submission
            }
        }
    </script>

    <script>
        // Menghapus pesan error saat pengguna mengetik di dalam input
        $('input').on('input', function() {
            $(this).removeClass('is-invalid');
            $(this).siblings('.alert-danger').remove();
        });
    </script>

    <script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "lengthMenu": [5, 10, 25, 50] // Menampilkan opsi untuk menampilkan 5, 10, 25, atau 50 data
            });
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
@endsection
