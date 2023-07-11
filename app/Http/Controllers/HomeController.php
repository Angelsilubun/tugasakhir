<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Gejala;
use App\Models\Diagnosa;
use App\Models\Penyakit;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        return view('home');
    }

    public function adminDashboard(): View
    {
        $users_count = User::where('role', 0)->count();
        $dianogsas_count = Diagnosa::count();
        $penyakits_count = Penyakit::count();
        $gejalas_count = Gejala::count();

        // chart user
        $userCount = User::where('role', 0)->count();
        $pakarCount = User::where('role', 2)->count();

        $topPenyakit = DB::table('diagnosas')
            ->join('rules', 'diagnosas.gejala_diagnosa', '=', 'rules.daftar_gejala')
            ->join('penyakits', 'rules.id_penyakit', '=', 'penyakits.id')
            ->select('penyakits.nama_penyakit', DB::raw('COUNT(*) as count'))
            ->groupBy('penyakits.nama_penyakit')
            ->orderBy('count', 'desc')
            ->limit(5) // Mengambil 5 penyakit teratas
            ->get();

        $topGejala = DB::table('diagnosas')
            ->select('gejala_diagnosa', DB::raw('COUNT(*) as count'))
            ->groupBy('gejala_diagnosa')
            ->orderBy('count', 'desc')
            ->limit(10) // Ambil 5 gejala teratas
            ->get();

        // Mengubah nilai gejala menjadi array dan mendapatkan nama gejala
        $gejalaIDs = $topGejala->pluck('gejala_diagnosa')->flatMap(fn ($gejala) => explode(',', $gejala))->unique()->toArray();
        $gejala = Gejala::whereIn('id', $gejalaIDs)->pluck('nama_gejala');

        $jumlahPasien = DB::table('diagnosas')
            ->select(DB::raw('MONTH(tanggal_diagnosa) as bulan'), DB::raw('YEAR(tanggal_diagnosa) as tahun'), DB::raw('COUNT(*) as count'))
            ->groupBy('bulan', 'tahun')
            ->get();


        return view('admin.dashboard.dashboard', compact(
            'users_count',
            'dianogsas_count',
            'penyakits_count',
            'gejalas_count',
            'topPenyakit',
            'topGejala',
            'gejala',
            'jumlahPasien',
            'userCount','pakarCount'
        ));
    }

        public function getTopPenyakit()
    {
        $penyakit = DB::table('diagnosas')
            ->join('rules', 'diagnosas.gejala_diagnosa', '=', 'rules.daftar_gejala')
            ->join('penyakits', 'rules.id_penyakit', '=', 'penyakits.id')
            ->select('penyakits.nama_penyakit', DB::raw('COUNT(*) as count'))
            ->groupBy('penyakits.nama_penyakit')
            ->orderBy('count', 'desc')
            ->limit(5) // Mengambil 5 penyakit teratas
            ->get();

        return response()->json(['penyakit' => $penyakit]);
    }

    public function getTotalUsers(): JsonResponse
{
    // Mengambil data jumlah pengguna per bulan
    $users = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bulan, COUNT(*) as jumlahUser')
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    // Mengubah format bulan menjadi format yang lebih mudah dibaca
    $formattedData = $users->map(function ($user) {
        $bulan = Carbon::createFromFormat('Y-m', $user->bulan)->locale('id')->isoFormat('MMMM Y');
        return [
            'bulan' => $bulan,
            'jumlahUser' => $user->jumlahUser
        ];
    });

    return response()->json($formattedData);
}

public function pakarDashboard(): View
{
    $users_count = User::where('role', 0)->count();
    $dianogsas_count = Diagnosa::count();
    $penyakits_count = Penyakit::count();
    $gejalas_count = Gejala::count();

    $topPenyakit = DB::table('diagnosas')
        ->join('rules', 'diagnosas.gejala_diagnosa', '=', 'rules.daftar_gejala')
        ->join('penyakits', 'rules.id_penyakit', '=', 'penyakits.id')
        ->select('penyakits.nama_penyakit', DB::raw('COUNT(*) as count'))
        ->groupBy('penyakits.nama_penyakit')
        ->orderBy('count', 'desc')
        ->limit(5) // Mengambil 5 penyakit teratas
        ->get();

    $topGejala = DB::table('diagnosas')
        ->select('gejala_diagnosa', DB::raw('COUNT(*) as count'))
        ->groupBy('gejala_diagnosa')
        ->orderBy('count', 'desc')
        ->limit(10) // Ambil 5 gejala teratas
        ->get();

    // Mengubah nilai gejala menjadi array dan mendapatkan nama gejala
    $gejalaIDs = $topGejala->pluck('gejala_diagnosa')->flatMap(fn ($gejala) => explode(',', $gejala))->unique()->toArray();
    $gejala = Gejala::whereIn('id', $gejalaIDs)->pluck('nama_gejala');

    $jumlahPasien = DB::table('diagnosas')
        ->select(DB::raw('MONTH(tanggal_diagnosa) as bulan'), DB::raw('YEAR(tanggal_diagnosa) as tahun'), DB::raw('COUNT(*) as count'))
        ->groupBy('bulan', 'tahun')
        ->get();



    return view('pakar.dashboard_pakar.dashboardp', compact(
        'users_count',
        'dianogsas_count',
        'penyakits_count',
        'gejalas_count',
        'topPenyakit',
        'topGejala',
        'gejala',
        'jumlahPasien',
    ));
}


    public function adminProfile(): View
    {
        $id = Auth::user()->id;
        $admin_profile = User::findOrFail($id);

        if($request->hasFile('image')){

            $image = $request->file('image');
            $image->storeAs('public/profile_admin', $image->hashName());

            Storage::delete('public/profile_admin/'.$user->image);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                // 'password' => bcrypt($request->password),
                'image' => $image->hashName(),
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
        }

        return view('admin.profile.index_profile', compact('admin_profile'));
    }
}
