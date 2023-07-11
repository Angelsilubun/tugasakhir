@extends('layouts_admin.main')

@section('title', 'Dashboard Pakar')

@section('container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-xxl-3 col-xl-3">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Total <span>| User</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people-fill"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $users_count }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-xl-3">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Total <span>| Diagnosa</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-file-earmark-medical"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $dianogsas_count }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-xl-3">

                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Daftar <span>| Penyakit</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-grid-1x2"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $penyakits_count }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-xl-3">

                            <div class="card info-card customers-card">

                                <div class="card-body">
                                    <h5 class="card-title">Daftar <span>| Gejala</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-grid-3x3-gap-fill"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $gejalas_count }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Grafik Penyakit yang Paling Banyak Dialami Pasien</div>
                            <div class="card-body">
                                <div class="chart-container" style="height: 300px;">
                                    <canvas id="grafikPenyakit"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Grafik Gejala yang Paling Banyak Dijawab oleh Pasien</div>
                            <div class="card-body">
                                <div class="chart-container" style="height: 300px;">
                                    <canvas id="grafikGejala"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Grafik Jumlah Pasien Diagnosa Berdasarkan Bulan dan Tahun</div>
                            <div class="card-body">
                                <div class="chart-container" style="height: 300px;">
                                    <canvas id="grafikPasien"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>

    @push('script')
        <script src="{{ asset('assets/chartJS_4-3-0/package/dist/chart.umd.js') }}"></script>

        <script>
            // Mendapatkan data gejala dan jumlahnya dari controller
            const gejala = @json($gejala);
            const jumlahGejala = @json($topGejala->pluck('count'));

            // Mendapatkan data penyakit dan jumlahnya dari controller
            const penyakit = @json($topPenyakit->pluck('nama_penyakit'));
            const jumlahPenyakit = @json($topPenyakit->pluck('count'));

            // Membuat chart gejala menggunakan Chart.js dengan tipe line
            const ctxGejala = document.getElementById('grafikGejala').getContext('2d');
            new Chart(ctxGejala, {
                type: 'line',
                data: {
                    labels: gejala,
                    datasets: [{
                        label: 'Jumlah Pasien',
                        data: jumlahGejala,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna latar belakang garis
                        borderColor: 'rgba(54, 162, 235, 1)', // Warna garis
                        borderWidth: 1,
                        lineTension: 0.3 // Mengatur kelengkungan garis
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0,
                            suggestedMax: Math.max(...jumlahGejala) + 1 // Nilai maksimum sumbu Y
                        }
                    },
                }
            });

            // Membuat chart penyakit menggunakan Chart.js dengan tipe polar
            const ctxPenyakit = document.getElementById('grafikPenyakit').getContext('2d');
            new Chart(ctxPenyakit, {
                type: 'polarArea',
                data: {
                    labels: penyakit,
                    datasets: [{
                        label: 'Jumlah Pasien',
                        data: jumlahPenyakit,
                        backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)',
                            'rgba(75, 192, 192, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(153, 102, 255, 0.5)'
                        ], // Warna latar belakang area polar
                        borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)', 'rgba(153, 102, 255, 1)'
                        ], // Warna garis
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        </script>

        <script>
            // Mendapatkan data bulan, tahun, dan jumlah pasien dari controller
            const bulanTahun = @json(
                $jumlahPasien->map(function ($item) {
                    return $item->bulan . '/' . $item->tahun;
                }));

            const jumlahPasienData = @json($jumlahPasien->pluck('count'));

            // Membuat chart menggunakan Chart.js
            const ctx = document.getElementById('grafikPasien').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: bulanTahun,
                    datasets: [{
                        label: 'Jumlah Pasien',
                        data: jumlahPasienData,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna latar belakang garis
                        borderColor: 'rgba(54, 162, 235, 1)', // Warna garis
                        borderWidth: 1,
                        lineTension: 0.4 // Mengatur kelengkungan garis (0 sampai 1)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0,
                            suggestedMax: Math.max(...jumlahPasienData) + 1 // Nilai maksimum sumbu Y
                        }
                    },
                }
            });
        </script>
    @endpush
@endsection
