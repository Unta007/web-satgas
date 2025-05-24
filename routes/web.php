<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController; // Masih diperlukan jika Auth::routes() tidak dicustom
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/educational-contents', function () {
    return view('educational_contents');
});

Route::get('/report.index', function () {
    return view('report.index');
});

Route::get('/educational-contents/{slug}', [ArticleController::class, 'show'])->name('article.show');

Auth::routes(['verify' => true]);
