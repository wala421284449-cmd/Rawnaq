<?php

use App\Http\Controllers\{AddressController,AdminController,AuthController,CityController,CustomerController,OwnerController};

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/')->group(function () {
    Route::get('login',[AuthController::class,'showLogin'])->name('login');
    Route::post('login',[AuthController::class,'login']);
});


Route::prefix('cms/admin/')->group(function () {
    Route::view('/', 'cms.parent');

    Route::resource('cities', CityController::class);
    Route::post('cities_update/{id}', [CityController::class, 'update'])->name('cities_update');

    Route::resource('addresses', AddressController::class);
    Route::post('addresses_update/{id}', [AddressController::class, 'update'])->name('addresses_update');

    Route::resource('admins', AdminController::class);
    Route::post('admins_update/{id}', [AdminController::class, 'update'])->name('admins_update');

    Route::resource('customers', CustomerController::class);
    Route::post('customers_update/{id}', [CustomerController::class, 'update'])->name('customers_update');

    Route::resource('owners', OwnerController::class);
    Route::post('owners_update/{id}', [OwnerController::class, 'update'])->name('owners_update');
});
