@extends('layouts_user.navbar')

@section('title', 'Hasil')

@section('container')
    <style>
        .deskripsi-penyakit p {
            padding: 0;
            margin: 0;
            display: inline
        }
    </style>
    <main id="main">
        <section id="contact" class="contact mt-4">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2 class="mb-2">Hasil Konsultasi</h2>
                </div>
                @if (session('success'))
                    <script>
                        showSuccessToast("{{ session('success') }}");
                    </script>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="col-md-12">
                    <div class="" data-aos="fade-up">
                        <h5>
                            <strong>DATA PASIEN</strong>
                        </h5>
                        <hr>
                        <div class="">
                            <dl class="row">
                                <dt class="col-sm-2">Nama Lengkap</dt>
                                <dd class="col-sm-10">: {{ $diagnosa->user->name }}</dd>

                                <dt class="col-sm-2">Jenis Kelamin</dt>
                                <dd class="col-sm-10">: {{ $diagnosa->user->jenis_kelamin }}</dd>

                                <dt class="col-sm-2 text-truncate">Umur</dt>
                                <dd class="col-sm-10">: {{ $diagnosa->user->umur . 'Tahun' }}</dd>

                                <dt class="col-sm-2 text-truncate">Alamat</dt>
                                <dd class="col-sm-10">: {{ $diagnosa->user->alamat }}</dd>

                                <dt class="col-sm-2 text-truncate">Tanggal Diagnosa</dt>
                                @php
                                    $tanggal = \Carbon\Carbon::parse($diagnosa->tanggal_diagnosa)
                                        ->timezone('Asia/Jakarta')
                                        ->locale('id_ID');
                                @endphp

                                <dd class="col-sm-10">: {{ $tanggal->isoFormat('DD/MM/YYYY (dddd)') }}</dd>
                            </dl>

                            <h5 class="mt-4">
                                <strong>KONSULTASI</strong>
                            </h5>
                            <hr>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Gejala</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gejalas as $gejala)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <h5 class="mt-5">
                                <strong>HASIL KONSULTASI</strong>
                            </h5>
                            <hr>
                            @php
                                function countMatchedSymptoms($rule, $gejalaDiagnosaArr)
                                {
                                    $daftarGejalaArr = explode(',', $rule['daftar_gejala']);
                                    $matchedSymptoms = array_intersect($gejalaDiagnosaArr, $daftarGejalaArr);
                                    return count($matchedSymptoms);
                                }
                                
                                function calculateMatchingPercentage($matchedSymptoms, $totalSymptoms)
                                {
                                    return round(($matchedSymptoms / $totalSymptoms) * 100, 2);
                                }
                                
                                $gejalaDiagnosaArr = explode(',', $diagnosa->gejala_diagnosa);
                                $gejalaValid = true;
                                $totalSymptoms = count($gejalaDiagnosaArr);
                                
                                // Memeriksa keberadaan semua gejala dalam gejala_diagnosa dalam daftar gejala yang valid
                                foreach ($gejalaDiagnosaArr as $gejala) {
                                    if (!$gejalas->contains('id', $gejala)) {
                                        $gejalaValid = false;
                                        break;
                                    }
                                }
                                
                                $matchedRule = null;
                                
                                if ($gejalaValid) {
                                    $bestMatchCount = 0; // Menyimpan jumlah gejala yang cocok terbanyak
                                    $bestMatchRule = null; // Menyimpan rule dengan kecocokan terbaik
                                    $bestMatchDiff = PHP_INT_MAX; // Menyimpan selisih terkecil dengan rule
                                    $closestRule = null; // Menyimpan rule dengan selisih terkecil
                                
                                    foreach ($rules as $rule) {
                                        $daftarGejalaArr = explode(',', $rule['daftar_gejala']);
                                        $matchedSymptoms = array_intersect($gejalaDiagnosaArr, $daftarGejalaArr);
                                        $matchedCount = count($matchedSymptoms);
                                        $matchingPercentage = ($matchedCount / $totalSymptoms) * 100;
                                
                                        // Memeriksa jika rule ini memiliki kecocokan gejala yang lebih baik dari sebelumnya
                                        if ($matchedCount === $totalSymptoms) {
                                            $matchedRule = $rule;
                                            break;
                                        } elseif ($matchingPercentage > $bestMatchCount) {
                                            $bestMatchCount = $matchingPercentage;
                                            $bestMatchRule = $rule;
                                        }
                                
                                        // Memeriksa jika perbedaan antara gejala pasien dan rule ini lebih kecil dari sebelumnya
                                        $diff = count(array_diff($gejalaDiagnosaArr, $daftarGejalaArr));
                                        if ($diff < $bestMatchDiff) {
                                            $bestMatchDiff = $diff;
                                            $closestRule = $rule;
                                        }
                                    }
                                
                                    // Jika tidak ada rule yang cocok, lakukan solusi penyakit dengan mengambil jawaban user terdekat pada rules
                                    if (!$matchedRule) {
                                        $matchedRule = $closestRule;
                                    }
                                }
                            @endphp

                            @if ($matchingPercentage === 0)
                                <div class="alert alert-info" role="alert">
                                    <p>Tidak ditemukan kesesuaian dengan peraturan sistem berdasarkan gejala yang Anda
                                        sampaikan.</p>
                                    <p>Mohon perhatikan bahwa hasil ini tidak menyingkirkan kemungkinan adanya kondisi
                                        penyakit. Untuk informasi lebih lanjut, sebaiknya Anda berkonsultasi dengan dokter
                                        atau tenaga medis terpercaya.</p>
                                </div>
                            @elseif ($matchedRule)
                                <div class="alert alert-light shadow" role="alert">
                                    <p style="font-weight: bold;" class="text-success">Dalam analisis Sistem Pakar,
                                        ditemukan kesesuaian dengan peraturan sistem sebesar {{ $matchingPercentage }}%.
                                        Berdasarkan gejala yang Anda sampaikan, kemungkinan Anda mengalami suatu kondisi
                                        penyakit.</p>

                                    <dl class="row">
                                        <dt class="col-sm-2">Nama Penyakit</dt>
                                        <dd class="col-sm-10">: {{ $matchedRule->penyakit->nama_penyakit }}</dd>

                                        <dt class="col-sm-2">Kode Penyakit</dt>
                                        <dd class="col-sm-10">: {{ $matchedRule->penyakit->kode_penyakit }}</dd>

                                        <dt class="col-sm-2">Deskripsi Penyakit</dt>
                                        <dd class="col-sm-10 deskripsi-penyakit">: {!! $matchedRule->penyakit->deskripsi !!}</dd>

                                        <hr>
                                        <div class="alert alert-success">
                                            <dt class="col-sm-2">Cara Penanganan:</dt>
                                            <dd class="col-sm-10"> {!! $matchedRule->penanganan !!}</dd>
                                        </div>
                                    </dl>

                                    <h5 class="my-3">
                                        <strong>Berikut beberapa artikel terkait:</strong>
                                    </h5>

                                    {{-- @if ($matchedRule && count($post_penyakit) > 0)
                                        <div class="row row-cols-1 row-cols-md-3 g-4 my-3"
                                            style="max-height: 480px; overflow-y: auto;" data-aos="fade-up">
                                            @php
                                                $matchedArticles = collect([]);
                                            @endphp

                                            @foreach ($post_penyakit as $item)
                                                @if ($item->id_penyakit === $matchedRule->penyakit->id)
                                                    @php
                                                        $matchedArticles->push($item);
                                                    @endphp

                                                    <div class="col">
                                                        <div class="card h-100">
                                                            <a href="{{ route('landingPageHome.showPostPenyakit', $item->slug_post_penyakit) }}"
                                                                class="text-black fw-bold">
                                                                <img src="{{ Storage::url($item->image_post_penyakit) }}"
                                                                    class="card-img-top" alt="{{ $item->id }}">
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
                                                                            <span
                                                                                class="badge bg-primary">{{ $tag['value'] }}</span>
                                                                        @endforeach
                                                                    @endif
                                                                </p>
                                                                <p class="card-text flex-grow-1"
                                                                    style="text-align: justify;">
                                                                    {!! Str::limit($item->description_post_penyakit, 80, '...') !!}
                                                                </p>
                                                                <div
                                                                    class="d-flex align-items-center mt-auto justify-content-between">
                                                                    <div>
                                                                        <p class="text-muted mb-1"><i
                                                                                class="bi bi-person-fill"></i>
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
                                                @endif
                                            @endforeach
                                            @if ($matchedArticles->isEmpty())
                                                <div class="alert alert-warning" role="alert">
                                                    Artikel belum dibuat untuk penyakit ini.
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            Artikel belum dibuat untuk penyakit ini.
                                        </div>
                                    @endif --}}
                                    @if ($matchedRule && count($post_penyakit) > 0)
                                        <div class="row row-cols-1 row-cols-md-3 g-4 my-3"
                                            style="max-height: 480px; overflow-y: auto;" data-aos="fade-up">
                                            @php
                                                $matchedArticles = $post_penyakit->where('id_penyakit', $matchedRule->penyakit->id);
                                            @endphp

                                            @if ($matchedArticles->isEmpty())
                                                <div class="alert alert-warning" role="alert">
                                                    Artikel belum dibuat untuk penyakit ini.
                                                </div>
                                            @else
                                                @foreach ($matchedArticles as $item)
                                                    <div class="col">
                                                        <div class="card h-100">
                                                            <a href="{{ route('landingPageHome.showPostPenyakit', $item->slug_post_penyakit) }}"
                                                                class="text-black fw-bold">
                                                                <img src="{{ Storage::url($item->image_post_penyakit) }}"
                                                                    class="card-img-top" alt="{{ $item->id }}">
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
                                                                            <span
                                                                                class="badge bg-primary">{{ $tag['value'] }}</span>
                                                                        @endforeach
                                                                    @endif
                                                                </p>
                                                                <p class="card-text flex-grow-1"
                                                                    style="text-align: justify;">
                                                                    {!! Str::limit($item->description_post_penyakit, 80, '...') !!}
                                                                </p>
                                                                <div
                                                                    class="d-flex align-items-center mt-auto justify-content-between">
                                                                    <div>
                                                                        <p class="text-muted mb-1"><i
                                                                                class="bi bi-person-fill"></i>
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
                                                @endforeach
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            Artikel belum dibuat untuk penyakit ini.
                                        </div>
                                    @endif

                                </div>
                            @else
                                <div class="alert alert-warning" role="alert">
                                    Tidak ada aturan yang cocok dengan gejala yang Anda berikan.
                                </div>
                            @endif
                            <div class="mt-3 text-center">
                                <a href="{{ route('diagnosa.showPrintDiagnosa', $diagnosa->id) }}"
                                    class="btn btn-primary mr-1"><i class="bi bi-printer"></i>
                                    Print</a>
                                <a href="/diagnosa" class="btn btn-warning mr-1 text-light"><i
                                        class="bi bi-arrow-clockwise"></i> Diagnosa ulang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('style')
    @endpush
@endsection
