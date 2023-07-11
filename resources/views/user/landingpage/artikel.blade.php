@extends('layouts_user.navbar')

@section('title', 'Artikel')

@section('container')
    <main id="main">
        <section id="services" class="services mt-4">

            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Artikel</h2>
                    <p>Dapatkan info kesehatan kanker payudara terpercaya. Sispak hadir dengan tujuan untuk memberikan informasi
                        seputar kesehatan payudara agar masyarakat Indonesia semakin melek tentang pentingnya menjaga kesehatan
                        payudara.</p>
                </div>
                @if (request()->has('search'))
                    <div data-aos="fade-up" class="my-3">
                        <a href="{{ route('landingPageArtikel.index') }}" class="btn btn-secondary">Back</a>
                        <h4 class="my-2">Hasil Pencarian untuk: "{{ request('search') }}"</h4>
                    </div>
                @endif
                <form action="{{ route('landingPageArtikel.index') }}" method="GET" data-aos="fade-up">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Search...">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
    
                <div class="row row-cols-1 row-cols-md-3 g-4 my-3" data-aos="fade-up">
                    @forelse ($post_penyakit as $item)
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
                        <div class="alert alert-info" role="alert">
                            Tidak ada artikel yang tersedia saat ini.
                        </div>
                    @endforelse
                </div>
                <div class="my-2" data-aos="fade-up">
                    {{ $post_penyakit->links() }}
                </div>
        </section>
    </main>
@endsection
