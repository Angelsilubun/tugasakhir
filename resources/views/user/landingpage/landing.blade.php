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

            <div class="section-title mt-5" data-aos="fade-up">
                <h2>Artikel</h2>
                <p>Dapatkan info kesehatan kanker payudara terpercaya. Sispak hadir dengan tujuan untuk memberikan informasi
                    seputar kesehatan payudara agar masyarakat Indonesia semakin melek tentang pentingnya menjaga kesehatan
                    payudara.</p>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4 my-3" data-aos="fade-up">
                @php
                    $postCount = count($post_penyakit);
                @endphp
                @forelse ($post_penyakit->take(6) as $item)
                    <div class="col">
                        <div class="card h-100">
                            <a href="{{ route('landingPageHome.showPostPenyakit', $item->slug_post_penyakit) }}"
                                class="text-black fw-bold">
                                <img src="{{ Storage::url($item->image_post_penyakit) }}" class="card-img-top"
                                    alt="{{ $item->id }}">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <a href="{{ route('landingPageHome.showPostPenyakit', $item->slug_post_penyakit) }}"
                                        class="text-black fw-bold">{{ $item->title_post_penyakit }}</a>
                                </h5>
                                <p class="card-tags">
                                    @php
                                        $tags = json_decode($item->tags_post_penyakit, true);
                                    @endphp

                                    @if (is_array($tags))
                                        @foreach ($tags as $tag)
                                            <span class="badge bg-primary">{{ $tag['value'] }}</span>
                                        @endforeach
                                    @endif
                                </p>
                                <p class="card-text flex-grow-1" style="text-align: justify;">
                                    {!! Str::limit($item->description_post_penyakit, 80, '...') !!}
                                </p>
                                <div class="d-flex align-items-center mt-auto justify-content-between">
                                    <div>
                                        <p class="text-muted mb-1"><i class="bi bi-person-fill"></i>
                                            {{ $item->user->name }}</p>
                                        <p class="text-muted"><i class="bi bi-clock"></i>
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('landingPageHome.showPostPenyakit', $item->slug_post_penyakit) }}"
                                            class="btn btn-primary">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ asset('assets/admin/img/card.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-tags">
                                    <span class="badge bg-secondary">Tag 1</span>
                                    <span class="badge bg-secondary">Tag 2</span>
                                    <span class="badge bg-secondary">Tag 3</span>
                                </p>
                                <p class="card-text  lh-base" style="text-align: justify;">This is a longer card with
                                    supporting text below as a
                                    natural lead-in to additional content. This content is a little bit
                                    longerasdasdasdasdasdlo.
                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                                <a href="#" class="btn btn-primary">Lihat</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            @if ($postCount >= 6)
                <!-- Tampilkan tombol "More Artikel" jika terdapat lebih dari 6 artikel -->
                <div class="text-center">
                    <a href="{{ route('landingPageArtikel.index') }}" class="btn btn-primary">More Artikel</a>
                </div>
            @endif
        </div>
    </section>
@endsection
