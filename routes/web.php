<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\ReportListController;
use App\Http\Controllers\UserNotificationController;

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
    Route::get('/report/{report}', [App\Http\Controllers\ReportController::class, 'show'])->name('reports.show');
    Route::get('/report/{report}/download', [App\Http\Controllers\ReportController::class, 'downloadUserEvidence'])->name('reports.downloadEvidence');
});

Route::get('/about-us', function () {
    return view('user.about');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [UserNotificationController::class, 'show'])->name('notifications.show'); // Untuk menandai terbaca dan redirect
    Route::post('/notifications/mark-all-as-read', [UserNotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});


// Rute untuk Admin melihat laporan (Contoh, bisa memerlukan middleware 'admin' tambahan)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/charts', [ChartController::class, 'index'])->name('charts.index');
    Route::get('/reports/unread', [ReportListController::class, 'unread'])->name('reports.unread');
    Route::get('/reports/review', [ReportListController::class, 'review'])->name('reports.review');
    Route::get('/reports/ongoing', [ReportListController::class, 'ongoing'])->name('reports.ongoing');
    Route::get('/reports/solved', [ReportListController::class, 'solved'])->name('reports.solved');
    Route::get('/reports/denied', [ReportListController::class, 'denied'])->name('reports.denied');
    Route::get('/reports/archived', [App\Http\Controllers\Admin\ReportListController::class, 'archived'])->name('reports.archived');
    Route::get('/reports/{report}/edit', [ReportListController::class, 'edit'])->name('reports.edit');
    Route::get('/reports/{report}/evidence/download', [ReportListController::class, 'downloadEvidence'])->name('reports.downloadEvidence');
    Route::put('/reports/{report}/update-status', [ReportListController::class, 'updateStatus'])->name('reports.updateStatus');
    Route::delete('/reports/{report}', [ReportListController::class, 'destroy'])->name('reports.destroy');
});
