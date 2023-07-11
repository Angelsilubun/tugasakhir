<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PakarController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\admin\GejalaController;
use App\Http\Controllers\ProfilePakarController;
use App\Http\Controllers\admin\PenyakitController;
use App\Http\Controllers\admin\PetunjukController;
use App\Http\Controllers\DashboardPakarController;
use App\Http\Controllers\RiwayatDiagnosaController;
use App\Http\Controllers\LandingPage\LandingPageHomeController;
use App\Http\Controllers\LandingPage\LandingPageArtikelController;
use App\Http\Controllers\Pakar\LandingPage\LandingPagePostPenyakitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [LandingPageHomeController::class, 'index'])->name('landingPageHome.index');
Route::get('/landingPageHome/showPostPenyakit/{slug}', [LandingPageHomeController::class, 'showPostPenyakit'])->name('landingPageHome.showPostPenyakit');
Route::get('/landingPage/artikel', [LandingPageArtikelController::class, 'index'])->name('landingPageArtikel.index');

Route::get('/petunjuk', [LandingpageController::class, 'index'])->name('landingPage.index');
// Route::resource('/tentang', LandingpageController::class);

Route::resource('diagnosa', DiagnosaController::class)->only([
    'index', 'store', 'show'
])->middleware('auth');

Route::get('hasil-dianogsa/print/{id}', [DiagnosaController::class, 'showPrintDiagnosa'])->name('diagnosa.showPrintDiagnosa');

Route::resource('riwayat_diagnosa', RiwayatDiagnosaController::class)->only([
    'index'
]);
Route::get('riwayat_diagnosa/landingpage', [RiwayatDiagnosaController::class, 'indexDiagnosaLandingPage'])->name('riwayat_diagnosa.indexDiagnosaLandingPage')->middleware('auth');
Route::get('/get-top-penyakit', [DiagnosaController::class, 'getTopPenyakit']);
Route::get('/get-total-users', [DiagnosaController::class, 'getTotalUsers']);

//admin
Route::get('/dashboard', function () {
    return view('/admin/dashboard/dashboard');
})->name('dashboard');

// Route::get('/dt_diagnosa', function () {
//     return view('/admin/riwayat_diagnosa/dt_diagnosa');
// });

Auth::routes();

Route::middleware(['auth', 'user-access:user'])->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'user-access:admin'])->group(function() {
    Route::get('/admin/dashboard/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::prefix("admin")->group(function() {
        Route::resource('profile', ProfileController::class);

        Route::resource('datauser', PakarController::class);

        Route::get("/edit", [PasienController::class, "edit"]);
        Route::put("/simpan/{id}", [PasienController::class, "update"]);
        Route::resource('datapasien', PasienController::class);

        Route::get("/edit", [AdminController::class, "edit"]);
        Route::put("/simpan/{id}", [AdminController::class, "update"]);
        Route::resource('dataadmin', AdminController::class);

        Route::resource('petunjuk_penggunaan', PetunjukController::class);
    });
});

Route::middleware(['auth', 'user-access:pakar'])->group(function() {
    Route::get('/pakar/dashboard_pakar/dashboardp', [HomeController::class, 'pakarDashboard'])->name('pakar.dashboard_pakar');
    Route::prefix("pakar")->group(function() {
        //data_gejala
        Route::get("/edit", [GejalaController::class, "edit"]);
        Route::put("/simpan/{id}", [GejalaController::class, "update"]);
        Route::resource('datagejala', GejalaController::class);

        Route::resource('dashboard/landingPage/landingPagePostPenyakit', LandingPagePostPenyakitController::class)->except([
            'create', 'edit',
        ]);
        Route::get('landingPage/landingPagePostPenyakit', [LandingPagePostPenyakitController::class, 'LandingPagePostPenyakit'])->name('landingPagePostPenyakit.lp.index');

        Route::resource('datapenyakit', PenyakitController::class);

        Route::resource('profilep', ProfilePakarController::class);

        Route::get("/edit", [RuleController::class, "edit"]);
        Route::put("/simpan/{id}", [RuleController::class, "update"]);
        Route::resource('basisrule', RuleController::class);

   });

});

