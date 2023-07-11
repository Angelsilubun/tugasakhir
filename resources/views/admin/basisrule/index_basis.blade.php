@extends('layouts_admin.main')

@section('title', 'Basis Rule')

@section('container')


    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="mb-2">Basis Rules</h1>

            @if (session('success'))
                <script>
                    showSuccessToast("{{ session('success') }}");
                </script>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('gagal'))
                <script>
                    showErrorToast("{{ session('gagal') }}");
                </script>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('gagal') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <script>
                    showErrorToast("{{ $errors->first() }}");
                </script>
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            <script>
                                showErrorToast("{{ $error }}");
                            </script>
                        @endforeach

                    </ul>
                </div>
            @endif
        </div>


        <section class="section profile">
            <section class="section">


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-grid gap-2 d-md-flex justify-content-md mt-3 mb-3">
                                    <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#tambah_basis"><i class="bi bi-plus-circle"></i> Tambah</button>
                                </div>

                                <!-- Default Table -->
                                <div class="table-responsive">
                                    <table class="table mt-4 table-hover align-middle" id="dataTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" class="text-nowrap">No</th>
                                                <th scope="col" class="text-nowrap">Kode Penyakit</th>
                                                <th scope="col" class="text-nowrap">Nama Penyakit</th>
                                                <th scope="col" class="text-nowrap">Gejala</th>
                                                <th scope="col" class="text-nowrap">Penanganan</th>
                                                <th scope="col" class="text-nowrap w-25">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($aturans as $rule => $item)
                                                <tr>
                                                    <th>{{ $loop->iteration }}</th>
                                                    <td>{{ $item->penyakit->kode_penyakit }}</td>
                                                    <td>{{ $item->penyakit->nama_penyakit }}</td>
                                                    <td>
                                                        @php
                                                            $gejalaIds = explode(',', $item->daftar_gejala);
                                                            $gejalaItems = [];
                                                            foreach ($gejala as $gejalaItem) {
                                                                if (in_array($gejalaItem->id, $gejalaIds)) {
                                                                    $gejalaItems[] = $gejalaItem;
                                                                }
                                                            }
                                                        @endphp
                                                        @foreach ($gejalaItems as $gejalaItem)
                                                            {{ $gejalaItem->kode_gejala }},
                                                        @endforeach
                                                    </td>
                                                    <td>{!! \Illuminate\Support\Str::limit($item->penanganan, 50) !!}</td>
                                                    <td>
                                                        <div class="btn-group d-flex" role="group">
                                                            <form onsubmit="return confirm('Apakah anda yakin?');"
                                                                action="{{ route('basisrule.destroy', $item->id) }}"
                                                                method="POST">
                                                                <button type="button"
                                                                    onclick="editRule({{ $item->id }})"
                                                                    class="btn btn-primary text-light btn-sm"
                                                                    data-bs-toggle="modal" data-bs-target="#edit_basis">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </button>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger text-light btn-sm">
                                                                    <i class="bi bi-trash3-fill"></i>
                                                                </button>
                                                            </form>
                                                        </div>
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

            <!-- Modal -->
            <div class="modal fade" id="tambah_basis" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Basis</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/pakar/basisrule') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="kode_penyakit" class="form-label">Kode Penyakit</label>
                                    <select name="id_penyakit" id="kode_penyakit" class="form-select"
                                        aria-label="Kode Penyakit">
                                        <option value="">Pilih Kode Penyakit</option>
                                        @foreach ($penyakits as $penyakit)
                                            <option value="{{ $penyakit->id }}">{{ $penyakit->kode_penyakit }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_penyakit')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama_penyakit" class="form-label">Nama Penyakit</label>
                                    <input type="text" name="nama_penyakit" id="nama_penyakit" class="form-control"
                                        placeholder="Nama Penyakit" readonly>
                                    @error('nama_penyakit')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <label for="daftar_gejala">Daftar Gejala</label>
                                <div class="form-control" style="max-height: 200px; overflow-y: auto; margin-top:10px">
                                    @foreach ($gejala as $item)
                                        <div class="">
                                            <div class="pretty p-icon p-curve p-jelly">
                                                <input class="form-check-input" type="checkbox" name="daftar_gejala[]"
                                                    value="{{ $item->id }}" id="gejala_{{ $item->id }}">
                                                <div class="state p-success">
                                                    <i class="icon bi bi-check"></i>
                                                    <label class="form-check-label" for="gejala_{{ $item->id }}">
                                                        {{ $item->kode_gejala }} - {{ $item->nama_gejala }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('daftar_gejala')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="col-md-12">
                                    <label class="form-label">Penanganan</label>
                                    <textarea class="form-control @error('penanganan') is-invalid @enderror" name="penanganan" id="editor"
                                        rows="3" placeholder="Enter penanganan">{{ old('penanganan') }}</textarea>
                                    @error('penanganan')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-12 mt-3">
                                    <label class="form-label">Penanganan</label>
                                    <textarea class="form-control" name="penanganan" rows="3" placeholder="Masukan penanganan">{{ old('penanganan') }}</textarea>
                                    @error('penanganan')
                                        <script>
                                            showErrorToast("{{ $message }}");
                                        </script>
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit_basis" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Gejala</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/pakar/basisrule') }}" method="POST" id="formEdit">
                            @method('PUT')
                            @csrf
                            <div class="modal-body" id="modal-content-edit">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('js')
    <script src="{{ url('https://code.jquery.com/jquery-3.6.1.min.js') }}"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function editRule(id) {
            let formEdit = document.getElementById("formEdit");
            formEdit.action = formEdit.action + "/" + id
            $.ajax({
                url: "{{ url('/pakar/basisrule') }}/" + id + "/edit",
                type: "GET",
                data: {
                    id: id
                },
                success: function(basis_rule) {
                    $("#modal-content-edit").html(basis_rule);
                    return true;
                }
            });
        }
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    @foreach ($aturans as $data => $rule)
        <script>
            ClassicEditor
                .create(document.querySelector('#editor-edit-{{ $rule->id }}'))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var kodePenyakit = document.getElementById('kode_penyakit');
            var namaPenyakit = document.getElementById('nama_penyakit');
            var penyakitData = {!! json_encode($penyakits) !!};

            kodePenyakit.addEventListener('change', function() {
                var selectedId = kodePenyakit.value;
                var selectedPenyakit = penyakitData.find(function(penyakit) {
                    return penyakit.id == selectedId;
                });

                namaPenyakit.value = selectedPenyakit ? selectedPenyakit.nama_penyakit : '';
            });
        });
    </script>

    <script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "lengthMenu": [5, 10, 25, 50] // Menampilkan opsi untuk menampilkan 5, 10, 25, atau 50 data
            });
        });
    </script>

    <script>
        function showSuccessToast(message) {
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                    type: 'success',
                    background: '#4caf50',
                    icon: {
                        className: 'bi bi-check',
                        tagName: 'i',
                        color: '#ffffff'
                    },
                    dismissible: true,
                    duration: 3000,
                    ripple: true
                }]
            });
            notyf.success(message);
        }

        function showErrorToast(message) {
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                    type: 'error',
                    background: '#f44336',
                    icon: {
                        className: 'bi bi-x',
                        tagName: 'i',
                        color: '#ffffff'
                    },
                    dismissible: true,
                    duration: 3000,
                    ripple: true
                }]
            });
            notyf.error(message);
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (document.querySelector('.alert-success')) {
                const successMessage = document.querySelector('.alert-success strong').textContent;
                showSuccessToast(successMessage);
            }

            if (document.querySelector('.alert-danger')) {
                const errorMessage = document.querySelector('.alert-danger strong').textContent;
                showErrorToast(errorMessage);
            }
        });
    </script>

@endsection
