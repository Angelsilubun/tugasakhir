<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Konsultasi</title>
    <style>
        /* Gaya umum */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            font-size: 24px;
            margin: 0;
            padding-bottom: 20px;
            border-bottom: 1px solid #ccc;
        }

        h5 {
            font-size: 18px;
            margin-top: 20px;
        }

        hr {
            margin: 10px 0;
            border-top: 1px solid #ccc;
        }

        p {
            margin: 0;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        /* Tampilan Kertas A4 */
        @media print {
            body {
                width: 210mm;
                height: 297mm;
                padding: 20mm;
                background-color: #fff;
                color: #000;
            }

            h2 {
                font-size: 24px;
                border-bottom: 1px solid #000;
            }

            h5 {
                font-size: 18px;
            }

            hr {
                border-top: 1px solid #000;
            }

            .alert {
                background-color: #fff;
                border: 1px solid #000;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <main id="main">
        <section id="faq" class="faq">
            <div class="container">
                <div class="section-title">
                    <h2 class="text-center">Hasil Konsultasi</h2>
                </div>
                <div class="col-md-12">
                    <div class="">
                        <h5><strong>DATA PASIEN</strong></h5>
                        <div class="">
                            <p>Nama Lengkap: {{ $diagnosa->user->name }}</p>
                            <p>Jenis Kelamin: {{ $diagnosa->user->jenis_kelamin }}</p>
                            <p>Umur: {{ $diagnosa->user->umur . ' Tahun' }}</p>
                            <p>Alamat: {{ $diagnosa->user->alamat }}</p>
                            <p>Tanggal Diagnosa:
                                {{ \Carbon\Carbon::parse($diagnosa->tanggal_diagnosa)->isoFormat('DD/MM/YYYY (dddd)') }}
                            </p>
                        </div>

                        <hr>
                        <h5 class="mt-4 text-center"><strong>KONSULTASI</strong></h5>

                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No</th>
                                    <th style="width: 90%;">Gejala</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gejalas as $gejala)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td> {{ $gejala->kode_gejala }} -
                                            {{ $gejala->nama_gejala }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr>
                        <h5 class="mt-5 text-center"><strong>HASIL KONSULTASI</strong></h5>
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
                                <p style="text-align: justify;">Tidak ditemukan kesesuaian dengan peraturan sistem
                                    berdasarkan gejala yang Anda
                                    sampaikan.</p>
                                <p style="text-align: justify;">Mohon perhatikan bahwa hasil ini tidak menyingkirkan
                                    kemungkinan adanya kondisi
                                    penyakit. Untuk informasi lebih lanjut, sebaiknya Anda berkonsultasi dengan dokter
                                    atau tenaga medis terpercaya.</p>
                            </div>
                        @elseif ($matchedRule)
                            <div class="alert alert-light shadow" role="alert">
                                <p style="text-align: justify;" class="text-success">Dalam analisis
                                    Sistem Pakar,
                                    ditemukan kesesuaian dengan peraturan sistem sebesar
                                    <b>{{ $matchingPercentage }}%</b>.
                                    Berdasarkan gejala yang Anda sampaikan, kemungkinan Anda mengalami suatu kondisi
                                    penyakit.</p>
                                <br>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Nama Penyakit</th>
                                            <td>{{ $matchedRule->penyakit->nama_penyakit }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Kode Penyakit</th>
                                            <td>{{ $matchedRule->penyakit->kode_penyakit }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Deskripsi Penyakit</th>
                                            <td>{{ $matchedRule->penyakit->deskripsi }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <div class="">
                                    <p><b>Cara Penanganan:</b></p>
                                    <p style="text-align: justify;">{!! $matchedRule->penanganan !!}</p>
                                </div>


                            </div>
                        @else
                            <div class="alert alert-warning" role="alert">
                                Tidak ada aturan yang cocok dengan gejala yang Anda berikan.
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
