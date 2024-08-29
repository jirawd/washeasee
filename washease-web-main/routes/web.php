<?php

use App\Http\Controllers\API\v1\Login;
use App\Http\Controllers\API\v1\Logout;
use App\Http\Controllers\CustomerPages;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\IsUserLoggedIn;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/private/map', [HomeController::class, 'private_map'])->name('api.private.map');

Route::get('/register', [HomeController::class, 'register'])->name('register');
Route::post('/auth/login/web', [Login::class, 'loginWeb'])->name('auth.login.web');
Route::get('/auth/logout/web', [Logout::class, 'logoutWeb'])->name('auth.logout.web');


// Customer Routes
Route::get('/customer/login', [HomeController::class, 'login'])->name('customer.login');
Route::middleware(IsUserLoggedIn::class)->prefix('/customer')->group(function () {
    Route::get('/dashboard', [CustomerPages::class, 'customer_dashboard'])->name('customer.dashboard');
    Route::get('/my-profile/{id}', [CustomerPages::class, 'my_profile'])->name('customer.my.profile');
    Route::get('/laundry-shops', [CustomerPages::class, 'customer_laundry_shop'])->name('customer.laundry.shop');
    Route::get('/my-laundry', [CustomerPages::class, 'customer_laundry'])->name('customer.my-laundry');
    Route::get('/self-service', [CustomerPages::class, 'customer_self_service'])->name('customer.self.service');
    Route::get('/pickup-only', [CustomerPages::class, 'customer_pickup_only'])->name('customer.pickup.only');
    Route::get('/pickup-delivery', [CustomerPages::class, 'customer_pickup_delivery'])->name('customer.pickup.delivery');
});

Route::post('set-shop-to-close', [CustomerPages::class, 'close_shop'])->name('shop.to.close');
Route::post('set-shop-to-open', [CustomerPages::class, 'open_shop'])->name('shop.to.open');
