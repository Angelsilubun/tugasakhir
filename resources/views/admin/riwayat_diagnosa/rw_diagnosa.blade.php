@extends('layouts_admin.main')

@section('title', 'Riwayat')

@section('container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Riwayat Diagnosa</h1>
        </div>

        <section class="section profile">
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body mt-4">

                                <!-- Default Table -->
                                <div class="table-responsive" style="overflow: auto;">
                                    <table class="table table-hover" id="dataTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-nowrap">No</th>
                                                <th class="text-nowrap">Nama Lengkap</th>
                                                <th class="text-nowrap">Gejala</th>
                                                <th class="text-nowrap">Tanggal Diagnosa</th>
                                                <th class="text-nowrap">Action</th>
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
                                                    <td>{{ $diagnosa->user->name }}</td>
                                                    <td>
                                                        @php
                                                            $gejalaIds = explode(',', $diagnosa->gejala_diagnosa);
                                                            $gejalaItems = [];
                                                            foreach ($gejalas as $gejalaItem) {
                                                                if (in_array($gejalaItem->id, $gejalaIds)) {
                                                                    $gejalaItems[] = $gejalaItem->kode_gejala;
                                                                }
                                                            }
                                                            $gejalaString = implode(', ', $gejalaItems);
                                                        @endphp
                                                        {{ $gejalaString }}
                                                    </td>
                                                    <td>{{ $tanggal->isoFormat('DD/MM/YYYY (dddd)') }}</td>
                                                    <td>
                                                        {{-- <div class="btn-group" role="group" aria-label="Action buttons">
                                                            <a class="btn btn-primary btn-sm"
                                                                href="{{ route('diagnosa.showPrintDiagnosa', $diagnosa->id) }}"
                                                                role="button">
                                                                <i class="bi bi-printer-fill"></i> Print
                                                            </a>
                                                            <a class="btn btn-info text-light btn-sm"
                                                                href="{{ route('diagnosa.show', Crypt::encryptString($diagnosa->id)) }}"
                                                                role="button">
                                                                <i class="bi bi-eye"></i> Lihat Hasil Diagnosa
                                                            </a>
                                                        </div> --}}
                                                        <div class="btn-group d-flex" role="group"
                                                            aria-label="Action buttons">
                                                            <form onsubmit="return confirm('Apakah anda yakin?');"
                                                                action="{{ route('riwayat_diagnosa.destroy', $diagnosa->id) }}"
                                                                method="POST">
                                                                @if (Auth::user()->role == 'admin')
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger text-light btn-sm">
                                                                        <i class="bi bi-trash3-fill"></i>
                                                                    </button>
                                                                @endif
                                                                <a class="btn btn-primary btn-sm"
                                                                    href="{{ route('diagnosa.showPrintDiagnosa', $diagnosa->id) }}"
                                                                    role="button">
                                                                    <i class="bi bi-printer-fill"></i>
                                                                </a>
                                                                <a class="btn text-light btn-sm"
                                                                    style="background-color: #009999"
                                                                    href="{{ route('diagnosa.show', Crypt::encryptString($diagnosa->id)) }}"
                                                                    role="button">
                                                                    <i class="bi bi-eye"></i>
                                                                </a>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- End Default Table Example -->
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </section>
    </main>
@endsection

@section('js')

    {{-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "lengthMenu": [5, 10, 25, 50] // Menampilkan opsi untuk menampilkan 5, 10, 25, atau 50 data
            });
        });
    </script>
@endsection
