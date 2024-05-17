<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard', 301);

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware(['auth']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware(['guest']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware(['auth']);