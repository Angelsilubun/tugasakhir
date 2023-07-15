<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Gejala;
use App\Models\Diagnosa;
use App\Models\Penyakit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RiwayatDiagnosaController extends Controller
{
    public function index()
    {
        $gejalas = Gejala::get();
        $penyakits = Penyakit::all();
        $rules = Rule::with(['gejalaDiagnosa', 'penyakit'])->get();
        $riwayatDiagnosa = Diagnosa::with(['user', 'penyakits','gejalas'])
        // ->where('user_id', auth()->user()->id)
        ->get();

        return view('admin.riwayat_diagnosa.rw_diagnosa
        ', compact('gejalas', 'penyakits', 'rules', 'riwayatDiagnosa'));
    }
    public function destroy($id)
{
    $riwayatDiagnosa = Diagnosa::find($id);

    if ($riwayatDiagnosa) {
        $riwayatDiagnosa->delete();
        return redirect()->route('riwayat_diagnosa.index')->with('success', 'Riwayat diagnosa berhasil dihapus.');
    } else {
        return redirect()->route('riwayat_diagnosa.index')->with('error', 'Riwayat diagnosa tidak ditemukan.');
    }
}

    public function indexDiagnosaLandingPage()
    {
        $gejalas = Gejala::get();
        $penyakits = Penyakit::all();
        $rules = Rule::with(['gejalaDiagnosa', 'penyakit'])->get();
        $riwayatDiagnosa = Diagnosa::with(['user', 'penyakits','gejalas'])
        ->where('user_id', auth()->user()->id)
        ->get();

        return view('user.diagnosa.riwayat_diagnosa', compact('gejalas', 'penyakits', 'rules', 'riwayatDiagnosa'));
    }

}
