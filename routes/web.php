<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::view('cms/admin/index', 'cms.parent');
Route::view('temp', 'cms.template');


Route::prefix('cms/admin/')->group(function () {
    Route::resource('cities', CityController::class);
    Route::post('cities_update/{id}', [CityController::class, 'update'])->name('cities_update');

    Route::resource('addresses', AddressController::class);
    Route::post('addresses_update/{id}', [AddressController::class, 'update'])->name('addresses_update');

    Route::resource('admins', AdminController::class);
    Route::post('admins_update/{id}', [AdminController::class, 'update'])->name('admins_update');

    // Route::resource('customers',CustomerController::class);
    // Route::post('customers_update/{id}', [CustomerController::class, 'update'])->name('customers_update');

    Route::resource('owners', OwnerController::class);
    Route::post('owners_update/{id}', [OwnerController::class, 'update'])->name('owners_update');
});
