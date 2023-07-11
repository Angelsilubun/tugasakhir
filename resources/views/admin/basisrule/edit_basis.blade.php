<input type="hidden" name="id" value="{{ $rule->id }}">
<div class="mb-3">
    <label for="kode_penyakit" class="form-label">Kode Penyakit</label>
    <select name="id_penyakit" id="kode_penyakit" class="form-select" aria-label="Kode Penyakit">
        <option value="">Pilih Kode Penyakit</option>
        @foreach ($penyakits as $penyakit)
            <option value="{{ $penyakit->id }}" {{ $penyakit->id == $rule->id_penyakit ? 'selected' : '' }}>
                {{ $penyakit->kode_penyakit }}
            </option>
        @endforeach
    </select>
    @error('id_penyakit')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="nama_penyakit" class="form-label">Nama Penyakit</label>
    <input type="text" name="nama_penyakit" id="nama_penyakit" class="form-control"
        value="{{ $rule->penyakit->nama_penyakit ?? '' }}" readonly>
    @error('nama_penyakit')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<label for="daftar_gejala">Daftar Gejala</label>
<div class="form-control" style="max-height: 200px; overflow-y: auto; margin-top:10px; margin-bottom:10px">
    @foreach ($gejala as $item)
        <div class="">
            <div class="pretty p-icon p-curve p-jelly">
                <input class="form-check-input" type="checkbox" name="daftar_gejala[]" value="{{ $item->id }}"
                    id="gejala_{{ $item->id }}" {{ in_array($item->id, $selectedGejala) ? 'checked' : '' }}>
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

{{-- <div class="col-md-12">
    <label class="form-label">Penanganan</label>
    <textarea class="form-control @error('penanganan') is-invalid @enderror" name="penanganan" rows="3"
        placeholder="Masukan penanganan">{!! old('penanganan', $rule->penanganan ?? '') !!}</textarea>
    @error('penanganan')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div> --}}

<div class="col-md-12">
    <label class="form-label">penanganan</label>
    <textarea class="form-control @error('penanganan') is-invalid @enderror" name="penanganan"
        id="editor2" rows="3" placeholder="Enter description">{!! old('penanganan', $rule->penanganan ?? '') !!}</textarea>
    @error('penanganan')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#editor2'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>