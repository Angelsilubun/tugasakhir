<?php

namespace App\Http\Controllers\admin;

use App\Models\Gejala;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class GejalaController extends Controller
{
    public function index(): View
    {
        $data_gejala = Gejala::orderBy('id', 'asc')->get();

        return view('pakar.datagejala.index_gejala', compact('data_gejala'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'kode_gejala' => 'required',
            'nama_gejala' => 'required',
            'deskripsi' => 'required',
        ],
        [
            'kode_gejala.required' => 'Kode gejala tidak boleh kosong.',
            'nama_gejala.required' => 'Nama gejala tidak boleh kosong.',
            'deskripsi.required' => 'Nama gejala tidak boleh kosong.',
        ]);

        Gejala::create([
            'kode_gejala' => $request->kode_gejala,
            'nama_gejala' => $request->nama_gejala,
            'deskripsi' => $request->deskripsi
        ]);

        if ($request) {
            return redirect()->route('datagejala.index')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->route('datagejala.index')->with('error', 'Data gagal ditambahkan');
        }
    }

    public function edit(string $id): View
    {
        $data_gejala = Gejala::findOrFail($id);

        return view('pakar.datagejala.edit', compact('data_gejala'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'kode_gejala' => 'required',
            'nama_gejala' => 'required',
            'deskripsi' => 'required',
        ],
        [
            'kode_gejala.required' => 'Kode gejala tidak boleh kosong.',
            'nama_gejala.required' => 'Nama gejala tidak boleh kosong.',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong.',
        ]);

        $data_gejala = Gejala::findOrFail($id);

        $data_gejala->update([
            'kode_gejala' => $request->kode_gejala,
            'nama_gejala' => $request->nama_gejala,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($request) {
            return redirect()->route('datagejala.index')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->route('datagejala.index')->with('error', 'Data gagal diupdate');
        }
    }

    public function destroy($id): RedirectResponse
    {
        $data_gejala = Gejala::findOrFail($id);

        $data_gejala->delete();

        return redirect()->route('datagejala.index')->with(['success', 'Data berhasil dihapus']);
    }
}
