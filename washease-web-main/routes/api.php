<?php

use App\Http\Controllers\API\v1\GeoApify;
use App\Http\Controllers\API\v1\LaundryShopsAPI;
use App\Http\Controllers\API\v1\Login;
use App\Http\Controllers\API\v1\Register;
use App\Http\Controllers\API\v1\Logout;
use App\Http\Controllers\API\v1\RiderAPI;
use App\Http\Controllers\API\v1\ServicesAPI;
use App\Http\Controllers\API\v1\UserAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/auth/login', [Login::class, 'login'])->name('api.auth.login');

Route::post('/auth/register', [Register::class, 'register'])->name('api.auth.register');
Route::get('/auth/logout', [Logout::class, 'logout'])->name('api.auth.logout');
Route::post('/getAddress', [GeoApify::class, 'getAddress'])->name('api.get-address');
Route::get('/get-all-laundry-shops', [LaundryShopsAPI::class, 'get_all_laundry_shops'])->name('api.get-laundry-shops');

Route::get('/get-all-services', [ServicesAPI::class, 'get_all_services'])->name('api.get-all-services');
Route::post('/get-all-services-category', [ServicesAPI::class, 'get_all_services_category'])->name('api.get.all.services.category');
Route::post('/get-basic-services-by-laundry-shops', [ServicesAPI::class, 'get_basic_services_by_laundry_shops'])->name('api.get.basic.services.by.laundry.shops');
Route::get('/get-basic-services-by-laundry-shops-id/{id}', [ServicesAPI::class, 'get_basic_services_by_laundry_shops_by_id'])->name('api.get.basic.services.by.laundry.shops.by.id');
Route::post('/get-all-laundry-shops-washing-machines', [ServicesAPI::class, 'get_all_laundry_shops_washing_machines'])->name('api.get.all.laundry.shops.washing.machines');
Route::post('/get-rider-details/{rider_id}', [RiderAPI::class, 'rider_details'])->name('api.get.rider.details');
Route::post('/get-rider-tasks/{transaction_id}', [RiderAPI::class, 'getRiderTask'])->name('api.get.rider.tasks');
Route::post('/get-all-rider-tasks/{rider_id}', [RiderAPI::class, 'getAllRiderTasks'])->name('api.get.all.rider.tasks');
//Route::get('/get-laundry-shop-ratings', [LaundryShopsAPI::class, 'laundryShopsRating'])->name('api.get.laundry.shops.ratings');
Route::get('/get-customer-details/{id}', [UserAPI::class, 'user_details'])->name('api.get.customer.details');
Route::get('/get-customer-transactions/{id}/{status?}', [UserAPI::class, 'user_transactions'])->name('api.get.customer.transactions');
