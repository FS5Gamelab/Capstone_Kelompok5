<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login', 301);

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'newUser'])->name('new-user');
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard.admin');
    Route::get('/dashboard-user', function () {
        return view('user.dashboard');
    })->name('dashboard.user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
