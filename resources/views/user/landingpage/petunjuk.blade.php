@extends('layouts_user.navbar')

@section('title', 'Petunjuk Penggunaan')

@section('container')
    <main id="main">
        <section id="services" class="services mt-4">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Petunjuk Penggunaan</h2>
                    <p>Silahkan lihat petunjuk dibawah ini untuk menggunakan aplikasi</p>
                </div>
                <div class="row">
                    @foreach ($petunjuk as $data)
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in">
                            <div class="icon-box icon-box-pink">
                                <img src="{{ Storage::url($data->image) }}" class="card-img-top"
                                        alt="{{ $data->id }}">
                                <h4 class="title">
                                    <a>{{ $data->judul_petunjuk }}</a>
                                </h4>
                                <div class="content pt-4 pt-lg-0">
                                    <p class="fst-italic">
                                        {!! $data->isi !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

    </main>
@endsection
