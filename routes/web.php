<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');


Route::get('/homepage', [CustomerController::class, 'index'])->name('homepage');
Route::get('/menu', [CustomerController::class, 'menu'])->name('menu');
Route::get('/reservation', [CustomerController::class, 'reservation'])->name('reservation');
Route::get('/about', [CustomerController::class, 'about'])->name('about');
Route::get('/blog', [CustomerController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [CustomerController::class, 'blogDetail'])->name('blog-detail');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

Route::get('/product/{slug}', [CustomerController::class, 'menuDetail'])->name('menu-detail');


Route::get('/dashboard', function () {
    return !auth()->user() ? redirect('/homepage') : (auth()->user()->role == 'admin' || auth()->user()->role == 'super admin' ? redirect('/admin-dashboard') : redirect('/homepage'));
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
    Route::get('/api/orders-data', [AdminController::class, 'getOrderData']);
    Route::get('/api/product-type-data', [AdminController::class, 'getProductTypeData']);
    Route::get('/api/reservations', [AdminController::class, 'getReservationsByDate']);


    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users/create', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.delete');

    Route::get('/users/deleted', [UserController::class, 'deleted'])->name('users.deleted');
    Route::post('/users/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/force-delete/{id}', [UserController::class, 'forceDelete'])->name('users.force-delete');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');
    Route::get('/categories/deleted', [CategoryController::class, 'deleted'])->name('categories.deleted');
    Route::post('/categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/force-delete/{id}', [CategoryController::class, 'forceDelete'])->name('categories.force-delete');

    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/create/checkSlug', [ProductController::class, 'checkSlug'])->middleware('auth');
    Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.delete');

    Route::get('/products/trash/deleted', [ProductController::class, 'trash'])->name('products.deleted');
    Route::post('/products/restore/{id}', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('/products/force-delete/{id}', [ProductController::class, 'forceDelete'])->name('products.force-delete');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::put('/orders/{id}/update', [OrderController::class, 'update'])->name('orders.update');

    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations');
    Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{id}/update', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{id}/delete', [ReservationController::class, 'destroy'])->name('reservations.delete');

    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
    Route::get('/blogs/create/checkSlug', [BlogController::class, 'checkSlug']);
    Route::post('/blogs/create', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
    Route::get('/blogs/edit/{id}', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{id}/update', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/delete/{id}', [BlogController::class, 'destroy'])->name('blogs.delete');


    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart-note/{id}', [CartController::class, 'updateNote'])->name('cart.note');
    Route::post('/checkout', [OrderController::class, 'checkOut'])->name('checkout');
    Route::get('/checkout', [OrderController::class, 'checkoutIndex'])->name('checkout-index');
    Route::get('/checkout/pending', [OrderController::class, 'checkoutPending'])->name('checkout-pending');
    Route::get('/checkout/prepare', [OrderController::class, 'checkoutPrepare'])->name('checkout-prepare');
    Route::get('/checkout/success', [OrderController::class, 'checkoutSuccess'])->name('checkout-success');
    Route::get('/checkout/failed', [OrderController::class, 'checkoutFailed'])->name('checkout-failed');
    Route::get('/checkout/cancel', [OrderController::class, 'checkoutCancel'])->name('checkout-cancel');
    Route::post('/pay/{id}', [OrderController::class, 'pay'])->name('pay');
    Route::post('/success/{id}', [OrderController::class, 'success'])->name('success');
    Route::post('/failed/{id}', [OrderController::class, 'failed'])->name('failed');
    Route::delete('/cart/{cartId}', [CartController::class, 'delete'])->name('cart.delete');

    Route::get('/order/{id}', [OrderController::class, 'detail'])->name('order.detail');

    Route::get('/my-reservations', [ReservationController::class, 'myReservation'])->name('my-reservations');
    Route::get('/detail-reservation/{id}', [ReservationController::class, 'detailReservation'])->name('detail-reservation');
    Route::post('/pay-reservation/{id}', [ReservationController::class, 'payReservation'])->name('pay-reservation');
    Route::post('/success-reservation/{id}', [ReservationController::class, 'successReservation'])->name('success-reservation');
    Route::post('/failed-reservation/{id}', [ReservationController::class, 'failedReservation'])->name('failed-reservation');

    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [CustomerController::class, 'profileUpdate'])->name('profile-update');
    Route::put('/security/update', [CustomerController::class, 'securityUpdate'])->name('security-update');
    Route::post('/image/update', [CustomerController::class, 'imageUpdate'])->name('image-update');

    Route::get('/review', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/review/edit/{id}', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/review/update/{id}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/review/delete/{id}', [ReviewController::class, 'destroy'])->name('review.delete');
});


Route::middleware('auth')->group(function () {
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/verify-email', [AuthController::class, 'notice'])
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{token}', [AuthController::class, 'verifyEmail'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});
