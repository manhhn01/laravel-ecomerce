<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front;
use App\Http\Controllers\Front\Auth\ResetPasswordController;
use App\Http\Controllers\Front\OAuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [Front\Auth\RegisterController::class, 'register']);
Route::post('/login', [Front\Auth\LoginController::class, 'login']);
Route::post('/logout', [Front\Auth\LoginController::class, 'logout']);
Route::middleware('throttle:email')->post('/forgot', [ResetPasswordController::class, 'sendResetMail']);
Route::middleware('throttle:verify_code')->post('/reset_password/verify', [ResetPasswordController::class, 'verifyCode']);
Route::middleware('throttle:verify_code')->put('/reset_password', [ResetPasswordController::class, 'resetPassword']);
Route::middleware('web')->group(function () {
    Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect']);
    Route::get('/auth/{provider}/cb', [OAuthController::class, 'handleCallback']);
});
Route::get('/images/{image}', [ImageController::class, 'show'])->where('image', '(.*)')->name('images');
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
    Route::get('/top', [Front\ProductController::class, 'topProducts']);
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
    Route::post('/upload/avatar', [ImageController::class, 'avatar']);

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

    /* ADDRESS */
    Route::prefix('/addresses')->group(function () {
        Route::get('/', [Front\AddressController::class, 'index']);
        Route::post('/', [Front\AddressController::class, 'store']);
        Route::put('/{id}', [Front\AddressController::class, 'update'])->whereNumber('id');
        Route::delete('/{id}', [Front\AddressController::class, 'destroy'])->whereNumber('id');
        //todo remove below
        Route::get('/child_divisions', [Front\AddressController::class, 'childDivisionsList']);
    });

    /* ORDERS */
    Route::prefix('/orders')->group(function(){
        Route::get('/', [Front\OrderController::class, 'index']);
    });
});

/* PAYMENT */
// Route::middleware('throttle:checkout')->prefix('/checkout')->group(function () {
Route::prefix('/checkout')->group(function () {
    Route::post('/', [Front\OrderController::class, 'store']);
});
Route::prefix('/payment')->group(function () {
    Route::get('/momo/redirect', [Front\OrderController::class, 'momoRedirect'])->name('momo.redirect');
    Route::post('/momo/notify', [Front\OrderController::class, 'momoIpn'])->name('momo.ipn');
});

/* ADDRESSES */
Route::get('/addresses/child_divisions', [Front\AddressController::class, 'childDivisionsList']);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);

    /* IMAGE */
    Route::prefix('/upload')->group(function () {
        Route::post('/products', [ImageController::class, 'product']);
    });

    /* PRODUCT */
    // Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::prefix('/products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/{id_slug}', [ProductController::class, 'show']);
        Route::patch('/{id_slug}', [ProductController::class, 'update']);
        Route::delete('/{id_slug}', [ProductController::class, 'destroy']);
    });

    /* SIZE */
    Route::resource('sizes', SizeController::class)->except(['edit', 'create']);

    /* COLOR */
    Route::resource('colors', ColorController::class)->except(['edit', 'create']);

    /* CATEGORY */
    Route::resource('categories', CategoryController::class)->except(['edit', 'create']);

    /* ORDER */
    Route::resource('orders', OrderController::class)->except(['edit', 'create']);

    /* RECEIVED NOTE */

    /* USER */
    Route::resource('users', UserController::class)->except(['create', 'store']);
    //role
    //permission

    /* REVIEW */
    Route::resource('reviews', ReviewController::class)->except(['create', 'store', 'edit']);

    /* SHOP MANAGE */
    //slide
    //logo
    //...
    // });
});
