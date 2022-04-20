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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [Front\Auth\RegisterController::class, 'register']);
Route::post('/login', [Front\Auth\LoginController::class, 'login']);
Route::middleware('throttle:email')->post('/forgot', [ResetPasswordController::class, 'sendResetMail']);
Route::middleware('throttle:verify_code')->post('/reset_password/verify', [ResetPasswordController::class, 'verifyCode']);
Route::middleware('throttle:verify_code')->post('/reset_password', [ResetPasswordController::class, 'resetPassword']);

/* PRODUCT */
Route::get('/products', [Front\ProductController::class, 'index']);
Route::get('/products/id/{product}', [Front\ProductController::class, 'show']);
Route::get('/products/{product:slug}', [Front\ProductController::class, 'show']);

/* CATEGORY */
Route::get('/categories', [Front\CategoryController::class, 'index']);
Route::get('/categories/id/{category}', [Front\CategoryController::class, 'show']);
Route::get('/categories/{category}', [Front\CategoryController::class, 'show']);

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

        /* BRAND */

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
