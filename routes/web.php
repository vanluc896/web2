<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/san-pham', [ClientProductController::class, 'index'])->name('product.index');
Route::get('/san-pham/{slug}', [ClientProductController::class, 'show'])->name('product.show');
Route::get('/danh-muc/{slug}', [ClientProductController::class, 'category'])->name('product.category');
Route::get('/thuong-hieu/{slug}', [ClientProductController::class, 'brand'])->name('product.brand');
Route::get('/tim-kiem', [ClientProductController::class, 'search'])->name('product.search');

Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/gio-hang/update-all', [CartController::class, 'updateAll'])->name('cart.updateAll');
Route::get('/gio-hang/xoa/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/gio-hang/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/thanh-toan', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/dat-hang', [CartController::class, 'placeOrder'])->name('cart.placeOrder');

Route::prefix('admin')
    ->name('ad.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::get('login', 'showLogin')->name('login');
        Route::post('login', 'login')->name('login.submit');

        Route::post('logout', 'logout')
            ->middleware('auth')
            ->name('logout');

        Route::get('forgot', 'showForgot')->name('forgot');
        Route::post('forgot', 'forgot');
        Route::post('forgot-link', 'forgotLink')->name('forgot.link');

        Route::get('reset-password', 'showReset')->name('reset.form');
        Route::post('reset-password', 'resetPassword')->name('reset.password');
    });

Route::prefix('admin')->name('ad.')->middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        $latestProducts = Product::select('id', 'proname', 'price', 'thumbnail', 'created_at')
            ->latest()
            ->limit(5)
            ->get();

        $latestOrders = Order::with('customer:id,fullname')
            ->select('id', 'customer_id', 'order_code', 'total_amount', 'status', 'created_at')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('latestProducts', 'latestOrders'));
    })->name('dashboard');

    Route::get('users/edit-password/{id}', [AuthController::class, 'editPassword'])
        ->name('users.editPassword');
    Route::post('users/update-password/{id}', [AuthController::class, 'updatePassword'])
        ->name('users.updatePassword');

    Route::middleware('roles:1')->group(function () {
        Route::get('/order', [OrderController::class, 'index'])->name('order.index');
        Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::post('/order/{id}/status', [OrderController::class, 'updateStatus'])
            ->name('order.updateStatus');

        Route::prefix('customers')
            ->name('customers.')
            ->controller(CustomerController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
            });

        Route::prefix('category')
            ->name('cate.')
            ->controller(CategoryController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('del');
                Route::get('/trash', 'trash')->name('trash');
                Route::patch('/{id}/restore', 'restore')->name('restore');
                Route::delete('/{id}/force-delete', 'forceDelete')->name('forceDelete');
            });

        Route::prefix('product')
            ->name('product.')
            ->controller(AdminProductController::class)
            ->group(function () {
                Route::get('/', 'index2')->name('index2');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('del');
                Route::get('/trash', 'trash')->name('trash');
                Route::patch('/{id}/restore', 'restore')->name('restore');
                Route::delete('/{id}/force-delete', 'forceDelete')->name('forceDelete');
            });

        Route::prefix('posts')
            ->name('posts.')
            ->controller(PostsController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('del');
            });

        Route::prefix('brands')
            ->name('brands.')
            ->controller(BrandController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('del');
                Route::get('/trash', 'trash')->name('trash');
                Route::patch('/{id}/restore', 'restore')->name('restore');
                Route::delete('/{id}/force-delete', 'forceDelete')->name('forceDelete');
            });

        Route::prefix('users')
            ->name('users.')
            ->controller(UsersController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('del');
            });
    });
});
