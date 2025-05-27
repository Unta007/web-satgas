<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReportController;

// ... Rute Auth dan lainnya ...
Auth::routes(['verify' => true]);

// Rute untuk halaman utama, dll. (Asumsi ada HomeController untuk 'home')
Route::get('/', function () {
    return view('user.index');
});

// Rute-rute yang sudah ada
Route::get('/educational-contents', function () {
    return view('user.educational_contents');
});
Route::get('/educational-contents/{slug}', [ArticleController::class, 'show'])->name('article.show');


// --- Rute untuk Fitur Laporan ---
Route::middleware(['auth'])->group(function () { // Semua rute laporan memerlukan login
    Route::get('/reports/create', [ReportController::class, 'showForm'])->name('reports.index');
    Route::post('/reports/create', [ReportController::class, 'store'])->name('reports.store');
});


// Rute untuk Admin melihat laporan (Contoh, bisa memerlukan middleware 'admin' tambahan)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function() {
    // Misal ReportController memiliki metode indexAdmin dan showAdmin
    // Route::get('/reports', [ReportController::class, 'indexAdmin'])->name('reports.index');
    // Route::get('/reports/{report}', [ReportController::class, 'showAdmin'])->name('reports.show');
});

// Rute '/report' yang Anda miliki sebelumnya, perlu diklarifikasi tujuannya
// Jika ini adalah halaman yang dilihat user setelah submit (seperti pesan sukses atau list laporan mereka):
Route::get('/report', function () {
    return view('user.report'); // Pastikan view 'user.report' sesuai tujuannya
})->name('user.report.status')->middleware('auth'); // Beri nama yang jelas
