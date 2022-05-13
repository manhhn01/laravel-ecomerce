<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front;
use App\Http\Controllers\Front\Auth\ResetPasswordController;
use App\Http\Controllers\Front\OAuthController;
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
Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect']);
Route::get('/auth/{provider}/cb', [OAuthController::class, 'handleCallback']);
/* HOME PAGE */
Route::get('/banners', [Front\HomeController::class, 'banners']);
Route::get('/home_nav', [Front\HomeController::class, 'nav']);
Route::get('/collections', [Front\HomeController::class, 'collections']);
Route::get('/flash_sale', [Front\HomeController::class, 'sale']);
Route::get('/trending_search', [Front\HomeController::class, 'trending']);

/* PRODUCT */
Route::prefix('/products')->group(function () {
    Route::get('/', [Front\ProductController::class, 'index']);
    Route::get('/search', [Front\ProductController::class, 'search']);
    Route::prefix('/{id_slug}')->group(function () {
        Route::get('/', [Front\ProductController::class, 'show']);
        Route::get('/related', [Front\ProductController::class, 'relatedProducts']); // Show all related

        /* REVIEW */
        Route::get('/reviews', [Front\ProductController::class, 'productReviews']); // Show all reviews
        Route::middleware('auth:sanctum')->group(function () {
            Route::put('/reviews/{review_id}', [Front\ProductController::class, 'likeReview']);
            Route::post('/review', [Front\ProductController::class, 'storeReview']);
        });
    });
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

    /* CHECKOUT */
    Route::prefix('/checkout')->group(function () {
        Route::post('/', [Front\OrderController::class, 'store']);
    });

    /* WISHLIST */
    Route::prefix('/wishlist')->group(function () {
        Route::get('/', [Front\WishlistProductController::class, 'index']);
        Route::post('/', [Front\WishlistProductController::class, 'store']);
        Route::put('/', [Front\WishlistProductController::class, 'update']);
        Route::delete('/{id}', [Front\WishlistProductController::class, 'destroy']);
    });

    /* ADDRESS */
    Route::prefix('/addresses')->group(function () {
        Route::get('/', [Front\AddressController::class, 'index']);
        Route::post('/', [Front\AddressController::class, 'store']);
        Route::put('/{id}', [Front\AddressController::class, 'update'])->whereNumber('id');
        Route::delete('/{id}', [Front\AddressController::class, 'destroy'])->whereNumber('id');
        Route::get('/child_divisions', [Front\AddressController::class, 'childDivisionsList']);
    });
});

/* PAYMENT */
Route::prefix('/payment/')->group(function () {
    Route::get('/momo/redirect', [Front\OrderController::class, 'momoRedirect'])->name('momo.redirect');
    Route::post('/momo/notify', [Front\OrderController::class, 'momoIpn'])->name('momo.ipn');
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
