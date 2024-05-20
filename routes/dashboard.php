<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::group([
        'middleware' => ['auth', 'auth.type:admin,user'],
        'prefix' => 'dashboard'
], function () {

        Route::get('/', [DashboardController::class, 'index'])
                ->name('dashboard');

        Route::get('categories/trash', [CategoryController::class, 'trash'])
                ->name('categories.trash');

        Route::put('categories/{category}/restore', [CategoryController::class, 'restore'])
                ->name('categories.restore');

        Route::delete('categories/{category}/force_delete', [CategoryController::class, 'forceDelete'])
                ->name('categories.forceDelete');


        Route::get('products/trash', [ProductController::class, 'trash'])
                ->name('products.trash');

        Route::put('products/{product}/restore', [ProductController::class, 'restore'])
                ->name('products.restore');

        Route::delete('products/{product}/force_delete', [ProductController::class, 'forceDelete'])
                ->name('products.forceDelete');


        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
});
