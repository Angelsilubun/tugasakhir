@extends('layouts_user.navbar')

@section('title', 'Home')

@section('container')
    <section id="hero">

        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <img src="{{ Storage::url($post_penyakit->image_post_penyakit) }}" class="card-img-top"
                            alt="{{ $post_penyakit->id }}">
                        <div class="card-body">
                            <h3 class="card-title my-3 fw-bold">{{ $post_penyakit->title_post_penyakit }}</h3>
                            <p class="card-text my-3 lh-lg" style="text-align: justify;">{!! $post_penyakit->description_post_penyakit !!}</p>
                            <div class="ratio ratio-16x9 my-2">
                                <iframe src="{{ $post_penyakit->video_post_penyakit }}" class="rounded"
                                    title="YouTube video {{ $post_penyakit->title_post_penyakit }}"
                                    allowfullscreen></iframe>
                            </div>
                            <p class="card-text my-2">Tags:
                                @php
                                    $tags = json_decode($post_penyakit->tags_post_penyakit, true);
                                @endphp

                                @if (is_array($tags))
                                    @foreach ($tags as $tag)
                                        <span class="badge bg-primary">{{ $tag['value'] }}</span>
                                    @endforeach
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('landingPageArtikel.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Search...">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Tags</h5>
                            <div class="btn-group">
                                <a href="#" class="btn btn-primary mx-1">Tag 1</a>
                                <a href="#" class="btn btn-primary mx-1">Tag 2</a>
                                <a href="#" class="btn btn-primary mx-1">Tag 3</a>
                            </div>
                        </div>
                    </div> --}}


                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-list-ul"></i> More Articles</h5>
                            <ul class="list-group list-group-flush">
                                @php
                                    $artikel_penyakit = $artikel_penyakit->shuffle();
                                @endphp

                                @foreach ($artikel_penyakit->slice(0, 10) as $item)
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ Storage::url($item->image_post_penyakit) }}" class="rounded me-3"
                                                alt="{{ $item->id }}" width="40" height="40">
                                            <div>
                                                <a
                                                    href="{{ route('landingPageHome.showPostPenyakit', $item->slug_post_penyakit) }}">{{ $item->title_post_penyakit }}
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection
