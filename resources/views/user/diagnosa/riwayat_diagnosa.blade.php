@extends('layouts_user.navbar')

@section('title', 'Riwayat Diagnosa')

@section('container')
    <main id="main">
        <section id="faq" class="faq">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Riwayat Diagnosa</h2>
                </div>

                <div class="col-md-12">
                    <div class="card" data-aos="fade-up">
                        <div class="card-body">
                            <div class="table-responsive" style="overflow: auto;">
                                <table id="diagnosaTable" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-nowrap">No</th>
                                            <th scope="col" class="text-nowrap">Tanggal Diagnosa</th>
                                            <th scope="col" class="text-nowrap">Gejala</th>
                                            <th scope="col" class="text-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($riwayatDiagnosa as $index => $diagnosa)
                                            @php
                                                $tanggal = \Carbon\Carbon::parse($diagnosa->tanggal_diagnosa)
                                                    ->timezone('Asia/Jakarta')
                                                    ->locale('id_ID');
                                            @endphp
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $tanggal->isoFormat('DD/MM/YYYY (dddd)') }}</td>
                                                <td>
                                                    @php
                                                        $gejalaIds = explode(',', $diagnosa->gejala_diagnosa);
                                                        $gejalaItems = [];
                                                        foreach ($gejalas as $gejalaItem) {
                                                            if (in_array($gejalaItem->id, $gejalaIds)) {
                                                                $gejalaItems[] = $gejalaItem->nama_gejala;
                                                            }
                                                        }
                                                        $gejalaString = implode(', ', $gejalaItems);
                                                    @endphp
                                                    {{ $gejalaString }}
                                                </td>


                                                <td>
                                                    <a class="btn btn-primary text-light btn-sm"
                                                        href="{{ route('diagnosa.show', Crypt::encryptString($diagnosa->id)) }}"
                                                        role="button">Lihat
                                                        Hasil Diagnosa</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection
