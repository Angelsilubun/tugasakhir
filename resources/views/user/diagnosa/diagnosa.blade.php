@extends('layouts_user.navbar')

@section('title', 'Diagnosa')

@section('container')
    <main id="main">
        <section id="contact" class="contact mt-4">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Diagnosa</h2>
                    <p>Membantu pengguna mendapatkan informasi awal tentang penyakit atau kondisi kesehatan yang mungkin dialami</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if (session('success'))
                            <script>
                                showSuccessToast("{{ session('success') }}");
                            </script>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @error('gejala_diagnosa')
                            <script>
                                showErrorToast("{{ $message }}");
                            </script>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @enderror
                        @auth
                            @if (Auth::user()->role == 'user')
                                <div class="card shadow-lg p-3 bg-body rounded" data-aos="fade-up">
                                    <div class="card-body">
                                        <p class="fw-bold">Silahkan pilih gejala yang Anda alami dari opsi dibawah ini!</p>
                                        <form action="{{ route('diagnosa.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="table-responsive" style="overflow: auto;">
                                                <table class="table table-hover w-100">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-nowrap">No</th>
                                                            <th class="text-nowrap w-75">Gejala</th>
                                                            <th class="text-nowrap w-25">Pilih Kondisi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($gejalas as $item)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>Apakah Anda mengalami gejala {{ $item->nama_gejala }}?</td>
                                                                <td class="form-group">
                                                                    <div class="pretty p-icon p-curve p-tada">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="gejala_diagnosa[]"
                                                                            id="gejala_diagnosa_{{ $item->id }}"
                                                                            value="{{ $item->id }}">
                                                                        <div class="state p-primary">
                                                                            <i class="icon bi bi-check"></i>
                                                                            <label class="form-check-label"
                                                                                for="gejala_diagnosa_{{ $item->id }}">
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-3 text-start">
                                                <button class="btn" style="background-color:#ff6781; color:white">Diagnosa Sekarang</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @else
                            <p data-aos="fade-up">Silahkan Login Terlebih dahulu</p>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
    </main>


    @push('js')
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
    @endpush
@endsection
