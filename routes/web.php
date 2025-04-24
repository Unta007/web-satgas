<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/educational-contents', function () {
    return view('educational_contents');
});
