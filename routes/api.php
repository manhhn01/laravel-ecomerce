<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front;
use App\Http\Controllers\Front\Auth\ResetPasswordController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [Front\Auth\RegisterController::class, 'register']);
Route::post('/login', [Front\Auth\LoginController::class, 'login']);
Route::middleware('throttle:email')->post('/forgot', [ResetPasswordController::class, 'sendResetMail']);
Route::middleware('throttle:verify_code')->post('/reset_password/verify', [ResetPasswordController::class, 'verifyCode']);
Route::middleware('throttle:verify_code')->put('/reset_password', [ResetPasswordController::class, 'resetPassword']);

/* PRODUCT */
Route::prefix('/products')->group(function () {
    Route::get('/search', [Front\ProductController::class, 'search']);
    Route::get('/{id_slug}', [Front\ProductController::class, 'show']);
});

/* CATEGORY */
Route::prefix('/categories')->group(function () {
    Route::get('/', [Front\CategoryController::class, 'index']);
    Route::get('/{id_slug}', [Front\CategoryController::class, 'show']);
});


/* USER */
Route::middleware('auth:sanctum')->prefix('/user')->group(function () {
    /* INFO */
    Route::get('/', [Front\UserController::class, 'show']);
    Route::patch('/', [Front\UserController::class, 'update']);
    Route::post('/avatar', [Front\UserController::class, 'uploadAvatar']);

    /* CART */
    Route::prefix('/cart')->group(function () {
        Route::get('/', [Front\CartProductController::class, 'index']);
        Route::post('/', [Front\CartProductController::class, 'store']);
        Route::put('/', [Front\CartProductController::class, 'update']);
        Route::put('/{id}', [Front\CartProductController::class, 'updateOne']);
        Route::delete('/{id}', [Front\CartProductController::class, 'destroy']);
    });

    /* WISHLIST */
    Route::prefix('/wishlist')->group(function () {
        Route::get('/', [Front\WishlistProductController::class, 'index']);
        Route::post('/', [Front\WishlistProductController::class, 'store']);
        Route::put('/', [Front\WishlistProductController::class, 'update']);
        Route::delete('/{id}', [Front\WishlistProductController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'login']);

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        /* PRODUCT */
        Route::resource('products', ProductController::class);
        //size
        //color

        /* CATEGORY */

        /* ORDER */

        /* RECEIVED NOTE */

        /* USER */
        //role
        //permission

        /* REVIEW */

        /* SHOP MANAGE */
        //slide
        //logo
        //...
    });
});
