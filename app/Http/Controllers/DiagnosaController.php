<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Rule;
use App\Models\Gejala;
use App\Models\Diagnosa;
use App\Models\Penyakit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\LandingPage\LandingPagePostPenyakit;

class DiagnosaController extends Controller
{
    public function index()
    {
        $gejalas = Gejala::get();
        $penyakits = Penyakit::all();
        $rules = Rule::with(['gejalaDiagnosa','penyakit'])->get();

        return view('user.diagnosa.diagnosa', compact('gejalas', 'penyakits', 'rules'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'gejala_diagnosa' => 'required|array',
            'gejala_diagnosa.*' => 'required|integer|exists:gejalas,id',
        ],
        [
            'gejala_diagnosa.required' => 'Gejala diagnosa tidak boleh kosong.',
            'gejala_diagnosa.array' => 'Gejala diagnosa harus berupa array.',
            'gejala_diagnosa.*.required' => 'Gejala diagnosa tidak boleh kosong.',
            'gejala_diagnosa.*.integer' => 'Gejala diagnosa harus berupa bilangan bulat.',
            'gejala_diagnosa.*.exists' => 'Gejala diagnosa tidak ditemukan.',
        ]);

        $diagnosa = new Diagnosa();
        $diagnosa->user_id = auth()->user()->id;
        $diagnosa->gejala_diagnosa = implode(',', $request->input('gejala_diagnosa'));
        $diagnosa->tanggal_diagnosa = now();
        $diagnosa->save();

        // dd($diagnosa);

        // Lanjutkan dengan logika penentuan penyakit berdasarkan gejala yang dipilih
        if($diagnosa)
        {
            return redirect()->route('diagnosa.show', Crypt::encryptString($diagnosa->id))->with('success', 'Diagnosa berhasil disimpan.');
        } else {
            return redirect()->route('diagnosa.index')->with('gagal', 'Diagnosa gagal disimpan.');
        }
    }


    // public function show($encryptId)
    // {
    //     $id = Crypt::decryptString($encryptId);

    //     $diagnosa = Diagnosa::with(['user', 'penyakits'])->findOrFail($id);
    //     $gejalaIds = explode(',', $diagnosa->gejala_diagnosa);
    //     $gejalas = Gejala::whereIn('id', $gejalaIds)->get();
    //     $penyakits = Penyakit::all();
    //     $rules = Rule::with(['gejalaDiagnosa', 'penyakit'])->get();
    //     $post_penyakit = LandingPagePostPenyakit::get();

    //     return view('user.diagnosa.hasil_diagnosa', compact('diagnosa', 'gejalas', 'penyakits', 'rules', 'post_penyakit'));
    // }

    public function show($encryptId)
{
    $id = Crypt::decryptString($encryptId);

    $diagnosa = Diagnosa::with(['user', 'penyakits'])->findOrFail($id);
    $gejalaIds = explode(',', $diagnosa->gejala_diagnosa);
    $gejalas = Gejala::whereIn('id', $gejalaIds)->get();
    $penyakits = Penyakit::all();
    $rules = Rule::with(['gejalaDiagnosa', 'penyakit'])->get();
    $post_penyakit = LandingPagePostPenyakit::get();

    $matchedRule = null;
    $gejalaDiagnosaArr = explode(',', $diagnosa->gejala_diagnosa);
    $gejalaValid = true;
    $totalSymptoms = count($gejalaDiagnosaArr);

    // Memeriksa keberadaan semua gejala dalam gejala_diagnosa dalam daftar gejala yang valid
    foreach ($gejalaDiagnosaArr as $gejala) {
        if (!$gejalas->contains('id', $gejala)) {
            $gejalaValid = false;
            break;
        }
    }

    if ($gejalaValid) {
        $bestMatchCount = 0; // Menyimpan jumlah gejala yang cocok terbanyak
        $bestMatchRule = null; // Menyimpan rule dengan kecocokan terbaik
        $bestMatchDiff = PHP_INT_MAX; // Menyimpan selisih terkecil dengan rule
        $closestRule = null; // Menyimpan rule dengan selisih terkecil

        foreach ($rules as $rule) {
            $daftarGejalaArr = explode(',', $rule['daftar_gejala']);
            $matchedSymptoms = array_intersect($gejalaDiagnosaArr, $daftarGejalaArr);
            $matchedCount = count($matchedSymptoms);
            $matchingPercentage = ($matchedCount / $totalSymptoms) * 100;

            // Memeriksa jika rule ini memiliki kecocokan gejala yang lebih baik dari sebelumnya
            if ($matchedCount === $totalSymptoms) {
                $matchedRule = $rule;
                break;
            } elseif ($matchingPercentage > $bestMatchCount) {
                $bestMatchCount = $matchingPercentage;
                $bestMatchRule = $rule;
            }

            // Memeriksa jika perbedaan antara gejala pasien dan rule ini lebih kecil dari sebelumnya
            $diff = count(array_diff($gejalaDiagnosaArr, $daftarGejalaArr));
            if ($diff < $bestMatchDiff) {
                $bestMatchDiff = $diff;
                $closestRule = $rule;
            }
        }

        // Jika tidak ada rule yang cocok, lakukan solusi penyakit dengan mengambil jawaban user terdekat pada rules
        if (!$matchedRule) {
            $matchedRule = $closestRule;
        }
    }

    return view('user.diagnosa.hasil_diagnosa', compact('diagnosa', 'gejalas', 'penyakits', 'rules', 'post_penyakit', 'matchedRule'));
}







    public function showPrintDiagnosa($id)
    {
        // $diagnosa = Diagnosa::with(['user', 'penyakits'])->findOrFail($id);
        // $gejalaIds = explode(',', $diagnosa->gejala_diagnosa);
        // $gejalas = Gejala::whereIn('id', $gejalaIds)->get();
        // $penyakits = Penyakit::all();
        // $rules = Rule::with(['gejalaDiagnosa', 'penyakit'])->get();

        $diagnosa = Diagnosa::with(['user', 'penyakits'])->findOrFail($id);
    $gejalaIds = explode(',', $diagnosa->gejala_diagnosa);
    $gejalas = Gejala::whereIn('id', $gejalaIds)->get();
    $penyakits = Penyakit::all();
    $rules = Rule::with(['gejalaDiagnosa', 'penyakit'])->get();
    $post_penyakit = LandingPagePostPenyakit::get();

    $matchedRule = null;
    $gejalaDiagnosaArr = explode(',', $diagnosa->gejala_diagnosa);
    $gejalaValid = true;
    $totalSymptoms = count($gejalaDiagnosaArr);

    // Memeriksa keberadaan semua gejala dalam gejala_diagnosa dalam daftar gejala yang valid
    foreach ($gejalaDiagnosaArr as $gejala) {
        if (!$gejalas->contains('id', $gejala)) {
            $gejalaValid = false;
            break;
        }
    }

    if ($gejalaValid) {
        $bestMatchCount = 0; // Menyimpan jumlah gejala yang cocok terbanyak
        $bestMatchRule = null; // Menyimpan rule dengan kecocokan terbaik
        $bestMatchDiff = PHP_INT_MAX; // Menyimpan selisih terkecil dengan rule
        $closestRule = null; // Menyimpan rule dengan selisih terkecil

        foreach ($rules as $rule) {
            $daftarGejalaArr = explode(',', $rule['daftar_gejala']);
            $matchedSymptoms = array_intersect($gejalaDiagnosaArr, $daftarGejalaArr);
            $matchedCount = count($matchedSymptoms);
            $matchingPercentage = ($matchedCount / $totalSymptoms) * 100;

            // Memeriksa jika rule ini memiliki kecocokan gejala yang lebih baik dari sebelumnya
            if ($matchedCount === $totalSymptoms) {
                $matchedRule = $rule;
                break;
            } elseif ($matchingPercentage > $bestMatchCount) {
                $bestMatchCount = $matchingPercentage;
                $bestMatchRule = $rule;
            }

            // Memeriksa jika perbedaan antara gejala pasien dan rule ini lebih kecil dari sebelumnya
            $diff = count(array_diff($gejalaDiagnosaArr, $daftarGejalaArr));
            if ($diff < $bestMatchDiff) {
                $bestMatchDiff = $diff;
                $closestRule = $rule;
            }
        }

        // Jika tidak ada rule yang cocok, lakukan solusi penyakit dengan mengambil jawaban user terdekat pada rules
        if (!$matchedRule) {
            $matchedRule = $closestRule;
        }
    }

        // Generate PDF
        $pdf = new Dompdf();
        $html = view('user.diagnosa.print', compact('diagnosa', 'gejalas', 'penyakits', 'rules', 'post_penyakit', 'matchedRule'))->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        // Download PDF
        // return $pdf->stream('diagnosa.pdf');
        return $pdf->stream($diagnosa->user->name . ' - ' . Carbon::parse($diagnosa->tanggal_diagnosa)->format('d-m-Y') . '.pdf');

    }


}
