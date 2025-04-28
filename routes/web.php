<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/educational-contents', function () {
    return view('educational_contents');
});

Route::get('/educational-contents/{slug}', [ArticleController::class, 'show'])->name('article.show');
