<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\ReceivedNote;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Route::prefix('/admin')->name('admin.')->group(function () {
//     Route::middleware(['auth', 'admin'])->group(function () {
//         Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
//         Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//         /* PRODUCT */
//         Route::resource('products', ProductController::class, ['name' => 'products']);

//         /* CATEGORY */
//         Route::resource('categories', CategoryController::class, ['name' => 'categories']);

//         /* BRAND */
//         Route::resource('brands', BrandController::class, ['name' => 'brands']);

//         /* ORDER */
//         Route::resource('orders', OrderController::class, ['name' => 'orders']);

//         /* COUPON */
//         Route::resource('coupons', CouponController::class, ['name' => 'coupons']);

//         /* RECEIVE NOTE */
//         // Route::resource('received-notes', ReceivedNoteController::class, ['name' => 'received-notes']);

//         /* USER */
//         Route::resource('users', UserController::class, ['name' => 'users']);
//     });

//     Route::middleware('guest')->group(function () {
//         Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
//         Route::post('/login', [LoginController::class, 'login']);
//     });
// });
/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.register');
    // return (App\Models\Product::first());
});

// OTHERS
Route::get('/reg', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/reg', [RegisterController::class, 'register']);
