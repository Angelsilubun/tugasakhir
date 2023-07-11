<?php

namespace App\Http\Controllers\admin;

use App\Models\Penyakit;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class PenyakitController extends Controller
{
    public function index(): View
    {
        $data_penyakit = Penyakit::orderBy('id', 'asc')->get();

        return view('admin.datapenyakit.index_penyakit', compact('data_penyakit'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'kode_penyakit' => 'required',
            'nama_penyakit' => 'required',
            'deskripsi' => 'required'
        ],
        [
            'kode_penyakit.required' => 'Kode penyakit tidak boleh kosong.',
            'nama_penyakit.required' => 'Nama penyakit tidak boleh kosong.',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong.'
        ]);

        Penyakit::create([
            'kode_penyakit' => $request->input('kode_penyakit'),
            'nama_penyakit' => $request->input('nama_penyakit'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        if ($request) {
            return redirect()->route('datapenyakit.index')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->route('datapenyakit.index')->with('error', 'Data gagal ditambahkan');
        }
    }

    public function edit(string $id): View
    {
        $data_penyakit = Penyakit::findOrFail($id);

        return view('admin.datapenyakit.edit', compact('data_penyakit'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'kode_penyakit' => 'required',
            'nama_penyakit' => 'required',
            'deskripsi' => 'required'
        ],
        [
            'kode_penyakit.required' => 'Kode penyakit tidak boleh kosong.',
            'nama_penyakit.required' => 'Nama penyakit tidak boleh kosong.',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong.'
        ]);

        $data_penyakit = Penyakit::findOrFail($id);

        $data_penyakit->update([
            'kode_penyakit' => $request->kode_penyakit,
            'nama_penyakit' => $request->nama_penyakit,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($request) {
            return redirect()->route('datapenyakit.index')->with('success', 'Data berhasil diubah');
        } else {
            return redirect()->route('datapenyakit.index')->with('error', 'Data gagal diubah');
        }

    }

    public function destroy($id): RedirectResponse
    {
        $data_penyakit = Penyakit::findOrFail($id);

        $data_penyakit->delete();

        return redirect()->route('datapenyakit.index')->with(['success', 'Data berhasil dihapus']);
    }
}
