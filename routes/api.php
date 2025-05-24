<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
// return $request->user();
// });

// Cara 1: Mendefinisikan semua route CRUD secara eksplisit
Route::get('/users', [UserController::class, 'index'])->name('api.users.index');       // Menampilkan daftar semua user
Route::post('/users', [UserController::class, 'store'])->name('api.users.store');       // Membuat user baru
Route::get('/users/{user}', [UserController::class, 'show'])->name('api.users.show');    // Menampilkan detail user spesifik
Route::put('/users/{user}', [UserController::class, 'update'])->name('api.users.update');  // Memperbarui user spesifik (PUT)
Route::patch('/users/{user}', [UserController::class, 'update'])->name('api.users.update'); // Memperbarui user spesifik (PATCH)
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('api.users.destroy'); // Menghapus user spesifik

// Cara 2: Menggunakan Route::apiResource (cara yang lebih ringkas)
Route::get('/reports', [ReportController::class, 'index'])->name('api.reports.index');       // Menampilkan daftar semua report
Route::post('/reports', [ReportController::class, 'store'])->name('api.reports.store');       // Membuat report baru
//Route::apiResource('users', UserController::class)->names('api.users'); //->middleware('auth:sanctum');
