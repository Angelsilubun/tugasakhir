@extends('layouts_user.navbar')

@section('title', 'Home')

@section('container')
    <section id="hero">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center"
                    data-aos="fade-up">
                    <div>
                        <h1>Sistem pakar diagnosa penyakit kanker payudara</h1>
                        <h2>Lebih dini kanker ditemukan,semakin besar peluang untuk sembuh</h2>
                        <a href="{{ url('diagnosa') }}" class="btn-get-started scrollto">Diagnosa Sekarang</a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left">
                    <img src="{{ asset('assets/img/hero-img.png') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    </section>
@endsection
