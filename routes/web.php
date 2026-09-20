<?php

use App\Http\Controllers\{AddressController, AdminController, AuthController, CategoryController, CityController, ContactMessageController, CustomerController, MediaGalleryController, OfferController, OrderController, OwnerController, PermissionController, ProductController, ReviewController, RoleController, ServiceController, StoreController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::view('/', 'cms.auth.login');

Route::middleware('guest:admin,customer,owner')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:admin,customer,owner');
Route::middleware(['auth:admin,customer,owner', \App\Http\Middleware\RequestLoggerMiddleware::class])->prefix('cms/admin/')->group(function () {
    Route::view('/', 'parent');
    Route::post('products/import', [ProductController::class, 'import'])->name('admin.products.import');
    Route::get('products/export', [ProductController::class, 'export'])->name('admin.products.export');

    // مسارات أرشيف المنتجات (بدون سلاش بالبداية)
    Route::get('products/archive', [ProductController::class, 'archive'])->name('admin.products.archive');
    Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('admin.products.restore');
    Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('admin.products.forceDelete');

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

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::get('roles/{id}/permissions', [RoleController::class, 'editRolePermissions'])->name('roles.edit-permissions');
    Route::post('roles/{id}/permissions', [RoleController::class, 'updateRolePermissions'])->name('roles.update-permissions');

    Route::resource('stores', StoreController::class);
    Route::post('stores_update/{id}', [StoreController::class, 'update'])->name('stores_update');

    Route::resource('media-galleries', MediaGalleryController::class);
    Route::resource('contact-messages', ContactMessageController::class);
    Route::put('contact-messages/{id}/status', [ContactMessageController::class, 'updateStatus'])->name('contact-messages.status');
    Route::post('media-galleries_update/{id}', [MediaGalleryController::class, 'update'])->name('media-galleries_update');

    Route::resource('categories', CategoryController::class);
    Route::post('categories_update/{id}', [CategoryController::class, 'update'])->name('categories_update');

    Route::resource('services', ServiceController::class);
    Route::post('services_update/{id}', [ServiceController::class, 'update'])->name('services_update');

    Route::resource('products', ProductController::class);
    Route::post('products_update/{id}', [ProductController::class, 'update'])->name('products_update');

    Route::resource('offers', OfferController::class);
    Route::post('offers_update/{id}', [OfferController::class, 'update'])->name('offers_update');

    Route::resource('orders', OrderController::class);
    Route::post('orders_update/{id}', [OrderController::class, 'update'])->name('orders_update');

    Route::resource('orderItems', OrderController::class);
    Route::post('orderItems_update/{id}', [OrderController::class, 'update'])->name('orderItems_update');

    Route::resource('reviews', ReviewController::class);
    Route::post('reviews_update/{id}', [ReviewController::class, 'update'])->name('reviews_update');

    // مسار الإشعارات (بدون سلاش بالبداية ليتوافق مع الـ prefix)
    Route::post('notifications/{id}/read', function ($id) {
        $user = auth('admin')->user() ?? auth('owner')->user() ?? auth('customer')->user();

        if ($user) {
            $notification = $user->notifications()->find($id);
            if ($notification) {
                $notification->markAsRead();
            }
        }

        return redirect()->back();
    })->name('admin.notifications.read');
});
