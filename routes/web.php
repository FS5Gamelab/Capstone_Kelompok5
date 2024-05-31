<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Livewire\RealtimeMessage;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::get('/message', RealtimeMessage::class);

Route::get('/homepage', [CustomerController::class, 'index'])->name('homepage');
Route::get('/menu', [CustomerController::class, 'menu'])->name('menu');
Route::get('/reservation', [CustomerController::class, 'reservation'])->name('reservation');
Route::get('/about', [CustomerController::class, 'about'])->name('about');
Route::get('/blog', [CustomerController::class, 'blog'])->name('blog');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');


Route::get('/dashboard', function () {
    return !auth()->user() ? redirect('/homepage') : (auth()->user()->role == 'admin' ? redirect('/admin-dashboard') : redirect('/homepage'));
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'newUser'])->name('new-user');
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/forgot', [AuthController::class, 'forgotIndex'])->name('password.request');
    Route::post('/forgot', [AuthController::class, 'forgot'])->name('password.email');
    Route::get('/password/reset/{token}', [AuthController::class, 'resetForm'])->name('password.reset');
    Route::put('/password/reset', [AuthController::class, 'reset'])->name('password.update');

    Route::get('/auth/google/redirect', [OAuthController::class, 'redirect'])->name('auth.redirect');
    Route::get('/auth/google/callback', [OAuthController::class, 'callback'])->name('auth.callback');
});


Route::middleware(['auth', 'auth.session', 'verified'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('dashboard.admin');

    Route::get('/users', [UserController::class, 'index'])->name('users');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');

    Route::get('/products', [ProductController::class, 'index'])->name('products');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::put('/orders/{id}/update', [OrderController::class, 'update'])->name('orders.update');

    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/checkout', [OrderController::class, 'checkOut'])->name('checkout');
    Route::get('/checkout', [OrderController::class, 'checkoutIndex'])->name('checkout-index');
    Route::get('/checkout/pending', [OrderController::class, 'checkoutPending'])->name('checkout-pending');
    Route::get('/checkout/prepare', [OrderController::class, 'checkoutPrepare'])->name('checkout-prepare');
    Route::get('/checkout/success', [OrderController::class, 'checkoutSuccess'])->name('checkout-success');
    Route::get('/checkout/failed', [OrderController::class, 'checkoutFailed'])->name('checkout-failed');
    Route::get('/checkout/cancel', [OrderController::class, 'checkoutCancel'])->name('checkout-cancel');
    Route::post('/pay/{id}', [OrderController::class, 'pay'])->name('pay');
    Route::post('/success/{id}', [OrderController::class, 'success'])->name('success');
    Route::delete('/cart/{cartId}', [CartController::class, 'delete'])->name('cart.delete');

    Route::get('/order/{id}', [OrderController::class, 'detail'])->name('order.detail');


    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [CustomerController::class, 'profileUpdate'])->name('profile-update');
    Route::put('/security/update', [CustomerController::class, 'securityUpdate'])->name('security-update');
    Route::post('/image/update', [CustomerController::class, 'imageUpdate'])->name('image-update');

    Route::get('/review', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/review/edit/{id}', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/review/update/{id}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/review/delete/{id}', [ReviewController::class, 'destroy'])->name('review.delete');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::middleware('auth')->group(function () {
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');

    Route::get('/verify-email', [AuthController::class, 'notice'])
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{token}', [AuthController::class, 'verifyEmail'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});
