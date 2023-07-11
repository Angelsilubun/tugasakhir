@extends('layouts_admin.main')

@section('title', 'Basis Rule')

@section('container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Basis Rule</h1>
            @if (session('success'))
                <script>
                    showSuccessToast("{{ session('success') }}");
                </script>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session('error'))
                <script>
                    showErrorToast("{{ session('error') }}");
                </script>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <form action="{{ route('basisrule.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-4">
                <label for="inputKd" class="form-label">Kode Penyakit</label>
                <select name="id_penyakit" id="id_penyakit">
                    @foreach ($penyakits as $item)
                        <option value="{{ $item->id }}">{{ $item->kode_penyakit }} -- {{ $item->nama_penyakit }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="daftar_gejala">Daftar Gejala</label>
                @foreach ($gejala as $item)
                    <div class="form-check">
                        <input class="form-check-input " type="checkbox" name="daftar_gejala[]" value="{{ $item->id }}"
                            id="gejala_{{ $item->id }}">
                        <label class="form-check-label" for="gejala_{{ $item->id }}">
                            {{ $item->kode_gejala }} - {{ $item->nama_gejala }}
                        </label>
                    </div>
                @endforeach
            </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
            </div>
        </form>

        </section>
    </main>
@endsection

@section('js')
    <script src="{{ url('https://code.jquery.com/jquery-3.6.1.min.js') }}"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function editPasien(id) {
            let formEdit = document.getElementById("formEdit");
            formEdit.action = formEdit.action + "/" + id
            $.ajax({
                url: "{{ url('/admin/datapasien') }}/" + id + "/edit",
                type: "GET",
                data: {
                    id: id
                },
                success: function(data_tentang) {
                    $("#modal-content-edit").html(data_tentang);
                    return true;
                }
            });
        }
    </script>
    @push('style')
        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    @endpush

    @push('script')
        {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#daftar_gejala').multipleSelect();
            });
        </script>
    @endpush
@endsection
