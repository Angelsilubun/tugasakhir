@extends('layouts_admin.main')

@section('title', 'Dashboard')

@section('container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Hasil Diagnosa</h1>
        </div>

        <section class="section profile">
            <section class="section">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 mt-4">
                                <div class="" data-aos="fade-up">
                                    <h6>
                                        <strong>DATA PASIEN</strong>
                                    </h6>
                                    <hr>
                                    <div class="">
                                        <dl class="row">
                                            <dt class="col-sm-3">Nama Lengkap</dt>
                                            <dd class="col-sm-8">: Lavanya Isvara Kaneishia</dd>

                                            <dt class="col-sm-3">Jenis Kelamin</dt>
                                            <dd class="col-sm-8">: Perempuan</dd>

                                            <dt class="col-sm-3 text-truncate">Umur</dt>
                                            <dd class="col-sm-8">: 19 Tahun</dd>

                                            <dt class="col-sm-3 text-truncate">Alamat</dt>
                                            <dd class="col-sm-8">: Jl Tirta Kencana IV. Kel. Tirtajaya Kec. Sukmajaya Kota
                                                Depok</dd>

                                            <dt class="col-sm-3 text-truncate">Tanggal Diagnosa</dt>
                                            <dd class="col-sm-8">: 25 Feb 2023</dd>
                                        </dl>

                                        <h6 class="mt-4">
                                            <strong>KONSULTASI</strong>
                                        </h6>
                                        <hr>

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Gejala Yang Dialami</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>G01 - Payudara Kemerahan</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>G02 - Payudara Kemerahan</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>G03 - Payudara Kemerahan</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>G04 - Payudara Kemerahan</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>G05 - Payudara Kemerahan</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <h6 class="mt-5">
                                            <strong>HASIL KONSULTASI</strong>
                                        </h6>
                                        <hr>

                                        <dl class="row">
                                            <dt class="col-sm-2">Nama Penyakit</dt>
                                            <dd class="col-sm-10">: Kanker Payudara Stadium 0</dd>

                                            <dt class="col-sm-2">Deskripsi</dt>
                                            <dd class="col-sm-10">: Stadium 0. Pada tingkat ini, ditemukan pertumbuhan sel
                                                abnormal pada
                                                jaringan payudara tetapi masih belum berkembang dan menyebar.</dd>

                                            <dt class="col-sm-2 text-truncate">Solusi</dt>
                                            <dd class="col-sm-10">: Cara pengobatan kanker payudara stadium 0 adalah dengan
                                                prosedur
                                                operasi untuk mengangkat sel kanker dan dilanjutkan dengan terapi untuk
                                                memastikan
                                                kanker tidak muncul kembali. </dd>
                                        </dl>


                                        {{-- <div class="alert alert-success" role="alert">
                                    <h5 class="alert-heading fw-bold">Kesimpulan</h5>
                                    <p>Berdasarkan gejala yang kamu pilih atau alami juga berdasarkan Role/basis aturan yang
                                        sudah ditentukan oleh seorang pakar maka dapat disimpulkan bahwa kamu terdiagnosis
                                        terkena penyakit kanker payudara stadium 0</p>
                                    <hr>
                                    <p class="mb-0">Solusi : Segera periksakan ke dokter terdekat agar kanker bisa ditangani
                                        sedari dini</p>
                                </div> --}}

                                        <div class="mt-3 text-center">
                                            <a href="#" target="_blank" class="btn btn-primary mr-1"><i
                                                    class="bi bi-printer"></i>
                                                Print
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </section>
    </main>
@endsection
