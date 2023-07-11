<?php

namespace App\Http\Controllers\admin;

use App\Models\Petunjuk;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PetunjukController extends Controller
{
    public function index(): View
    {
        $data_petunjuk = Petunjuk::orderBy('id', 'asc')->get();

        return view('admin.petunjuk_penggunaan.index_petunjuk', compact('data_petunjuk'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'judul_petunjuk' => 'required',
            'isi' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,jpg,png',
        ],
        [
            'judul_petunjuk.required' => 'Judul Petunjuk tidak boleh kosong',
            'isi.required' => 'Isi tidak boleh kosong',
            'image' => 'Gambar tidak boleh kosong'
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Proses penyimpanan data jika validasi berhasil

        // Simpan data post penyakit ke database
        $petunjuk = new Petunjuk();
        $petunjuk->judul_petunjuk = $request->judul_petunjuk;
        $petunjuk->isi = $request->isi;
        
        // Simpan gambar dengan nama acak
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $path = $request->file('image')->storeAs('public/petunjuk', $fileName);
            $petunjuk->image = 'public/petunjuk/' . $fileName;
        }

        $petunjuk->save();

        // Redirect atau tampilkan pesan sukses
        return back()->with('success', 'Petunjuk penggunaan berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul_petunjuk' => 'required',
            'isi' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,jpg,png',
        ],
        [
            'judul_petunjuk.required' => 'Judul Petunjuk tidak boleh kosong',
            'isi.required' => 'Isi tidak boleh kosong',
            'image' => 'Gambar tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses update data jika validasi berhasil

        // Cari post penyakit berdasarkan ID
        $petunjuk = Petunjuk::find($id);
        if (!$petunjuk) {
            return back()->with('error', 'Petunjuk penggunaan tidak ditemukan');
        }

        // Update data post penyakit
        $petunjuk->judul_petunjuk = $request->judul_petunjuk;
        $petunjuk->isi = $request->isi;

        // Update gambar jika ada file yang diupload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $path = $request->file('image')->storeAs('public/petunjuk', $fileName);
            $petunjuk->image = 'public/petunjuk/' . $fileName;
        }

        $petunjuk->save();

        // Redirect atau tampilkan pesan sukses
        return back()->with('success', 'Petunjuk penggunaan berhasil diupdate');
    }

    public function destroy($id)
    {
        $petunjuk = Petunjuk::find($id);
        if (!$petunjuk) {
            return back()->with('error', 'Post Penyakit tidak ditemukan');
        }

        // Hapus gambar terkait post penyakit jika ada
        if (!empty($petunjuk->image)) {
            Storage::delete($petunjuk->image);
        }

        // Hapus post penyakit dari database
        $petunjuk->delete();

        // Redirect atau tampilkan pesan sukses
        return back()->with('success', 'Petunjuk penggunaan berhasil dihapus');
    }

}
