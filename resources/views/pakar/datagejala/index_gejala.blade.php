@extends('layouts_admin.main')

@section('title', 'Penyakit')

@section('container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="mb-2">Data Gejala</h1>
            @if (session('success'))
                <script>
                    showSuccessToast("{{ session('success') }}");
                </script>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <script>
                    showErrorToast("{{ session('error') }}");
                </script>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('error') }}</strong>
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
                                        data-bs-target="#tambah_gejala"><i class="bi bi-plus-circle"></i> Tambah</button>
                                </div>

                                <!-- Default Table -->
                                <div class="table-responsive">
                                    <table class="table mt-3 table-hover align-middle" id="dataTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" class="text-nowrap">No</th>
                                                <th scope="col" class="text-nowrap">Kode Gejala</th>
                                                <th scope="col" class="text-nowrap">Nama Gejala</th>
                                                <th scope="col" class="text-nowrap w-25">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_gejala as $gejala)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $gejala->kode_gejala }}</td>
                                                    <td>{!! \Illuminate\Support\Str::limit($gejala->nama_gejala, 50) !!}</td>
                                                    <td class="d-flex">
                                                        <div class="btn-group" role="group">
                                                            <form onsubmit="return confirm('Apakah anda yakin?');"
                                                                action="{{ route('datagejala.destroy', $gejala->id) }}"
                                                                method="POST">
                                                                <button type="button"
                                                                    class="btn btn-primary text-light btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    href="#edit_gejala{{ $gejala->id }}" nowrap>
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </button>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger text-light btn-sm" nowrap>
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
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @include('pakar.datagejala.edit')

            <!-- Modal -->
            <div class="modal fade" id="tambah_gejala" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Gejala</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/pakar/datagejala') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Kode gejala</label>
                                        <input type="kode" name="kode_gejala"
                                            class="form-control @error('kode_gejala') is-invalid @enderror"
                                            value="{{ old('kode_gejala') }}" required>
                                        @error('kode_gejala')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Nama gejala</label>
                                        <input type="nama" name="nama_gejala"
                                            class="form-control @error('nama_gejala') is-invalid @enderror"
                                            value="{{ old('nama_gejala') }}" required>
                                        @error('nama_gejala')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
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
