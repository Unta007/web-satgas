<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ChartController;

// ... Rute Auth dan lainnya ...
Auth::routes(['verify' => true]);

// Rute untuk halaman utama, dll. (Asumsi ada HomeController untuk 'home')
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute-rute yang sudah ada
Route::get('/educational-contents', function () {
    return view('user.educational_contents');
});
Route::get('/educational-contents/{slug}', [ArticleController::class, 'show'])->name('article.show');


// --- Rute untuk Fitur Laporan ---
Route::middleware(['auth'])->group(function () { // Semua rute laporan memerlukan login
    Route::get('/report', [ReportController::class, 'showForm'])->name('reports.index');
    Route::post('/reports/create', [ReportController::class, 'store'])->name('reports.store');
});

Route::get('/about-us', function () {
    return view('user.about');
});


// Rute untuk Admin melihat laporan (Contoh, bisa memerlukan middleware 'admin' tambahan)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/charts', [ChartController::class, 'index'])->name('charts.index');
});
