<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\ReportListController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\UserProfileController;

// ... Rute Auth dan lainnya ...
Auth::routes(['verify' => true]);

// Rute untuk halaman utama, dll. (Asumsi ada HomeController untuk 'home')
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/educational-contents', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/edukasi/search', [ArticleController::class, 'search'])->name('articles.search');
Route::get('/educational-contents/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');


// --- Rute untuk Fitur Laporan ---
Route::middleware(['auth'])->group(function () { // Semua rute laporan memerlukan login
    Route::get('/report', [ReportController::class, 'showForm'])->name('reports.index');
    Route::post('/reports/create', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/report/{report}', [App\Http\Controllers\ReportController::class, 'show'])->name('reports.show');
    Route::get('/report/{report}/download', [App\Http\Controllers\ReportController::class, 'downloadUserEvidence'])->name('reports.downloadEvidence');

    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/photo', [UserProfileController::class, 'updatePhoto'])->name('profile.update_photo');
    Route::post('/profile/details', [UserProfileController::class, 'updateDetails'])->name('profile.update_details');
    Route::post('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.update_password');
});

Route::get('/about-us', function () {
    return view('user.about');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [UserNotificationController::class, 'show'])->name('notifications.show'); // Untuk menandai terbaca dan redirect
    Route::post('/notifications/mark-all-as-read', [UserNotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});


// Rute untuk Admin (Contoh, bisa memerlukan middleware 'admin' tambahan)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
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
    Route::resource('articles', AdminArticleController::class);
    Route::post('articles/upload-image', [AdminArticleController::class, 'uploadImage'])->name('articles.upload_image');
    Route::patch('testimonials/{testimonial}/toggle', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggle'])->name('testimonials.toggle');
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
    Route::resource('users', AdminUserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'show' => 'users.show',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ])->middleware('role:global_admin');
    Route::get('logs', [ActivityLogController::class, 'index'])
        ->name('logs.index');
    Route::get('profile', [AdminProfileController::class, 'edit'])->name('profile');
    Route::put('profile/update-password', [AdminProfileController::class, 'updatePassword'])->name('profile.update_password');
    Route::post('profile/update-photo', [AdminProfileController::class, 'updatePhoto'])->name('profile.update_photo');
});
