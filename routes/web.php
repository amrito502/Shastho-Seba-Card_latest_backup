<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/organizations', [HomeController::class, 'search'])->name('homes.index');
Route::get('/verification', [HomeController::class, 'viewVerification'])->name('verification');
Route::get('/verification-result', [HomeController::class, 'verifyMember'])->name('verification.result');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
