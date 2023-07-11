<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Gejala;
use App\Models\Penyakit;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\Paginator;

class RuleController extends Controller
{
    public function index()
    {
        $aturans = Rule::with(['penyakit', 'gejala'])
                    ->orderBy('id', 'asc')
                    ->get();
        $penyakits = Penyakit::get();
        $gejala = Gejala::all();

        return view('admin.basisrule.index_basis', compact(
            'aturans',
            'penyakits',
            'gejala'
        ));
    }

    public function store(Request $request)
{
    // Validasi input jika diperlukan
    $request->validate([
        'id_penyakit' => 'required',
        'daftar_gejala' => 'required|array',
        'penanganan' => 'required|string',
    ],
    [
        'id_penyakit.required' => 'Penyakit tidak boleh kosong.',
        'daftar_gejala.required' => 'Gejala tidak boleh kosong.',
        'daftar_gejala.array' => 'Gejala harus berupa array.',
        'penanganan.required' => 'Penanganan tidak boleh kosong.',
        'penanganan.string' => 'Penanganan harus berupa string.',
    ]);

    // Menyimpan data ke dalam tabel 'rules'
    $rule = new Rule;
    $rule->id_penyakit = $request->input('id_penyakit');
    $rule->daftar_gejala = implode(',', $request->input('daftar_gejala'));
    $rule->penanganan = $request->input('penanganan');

    $rule->save();

    // Redirect atau berikan respons sesuai kebutuhan Anda
    if ($rule) {
        return redirect()->route('basisrule.index')->with('success', 'Data berhasil ditambahkan');
    } else {
        return redirect()->route('basisrule.index')->with('gagal', 'Data gagal ditambahkan');
    }
}


    public function edit(string $id)
    {
        $rule = Rule::findOrFail($id);
        $penyakits = Penyakit::get();
        $gejala = Gejala::all();

        // Mendapatkan daftar gejala yang telah dipilih pada data yang akan diupdate
        $selectedGejala = explode(',', $rule->daftar_gejala);

        return view('admin.basisrule.edit_basis', compact('rule', 'penyakits', 'gejala', 'selectedGejala'));
    }

    public function update(Request $request, string $id)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'id_penyakit' => 'required',
            'daftar_gejala' => 'required|array',
        ],
        [
            'id_penyakit.required' => 'Penyakit tidak boleh kosong.',
            'daftar_gejala.required' => 'Gejala tidak boleh kosong.',
            'daftar_gejala.array' => 'Gejala harus berupa array.',
        ]);

        // Temukan data Rule berdasarkan id
        $rule = Rule::findOrFail($id);

        // Update data Rule
        $rule->id_penyakit = $request->input('id_penyakit');
        $rule->daftar_gejala = implode(',', $request->input('daftar_gejala'));
        $rule->penanganan = $request->input('penanganan');
        $rule->save();

        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('basisrule.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        // Temukan data Rule berdasarkan id
        $rule = Rule::findOrFail($id);

        // Hapus data Rule
        $rule->delete();

        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect()->route('basisrule.index')->with('success', 'Data berhasil dihapus');
    }
}
