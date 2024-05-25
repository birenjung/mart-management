<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthenticationController::class, 'index'])->name('index');
Route::get('login', [AuthenticationController::class, 'Login'])->name('authentication.login');
Route::post('login', [AuthenticationController::class, 'PostLogin'])->name('authentication.post.login');
Route::get('forgot-password', [AuthenticationController::class, 'ForgotPassword'])->name('authentication.forgot-password');
Route::post('forgot-password', [AuthenticationController::class, 'PostForgotPassword'])->name('authentication.post.forgot-password');
Route::get('reset-password/{id}', [AuthenticationController::class, 'ResetPassword'])->name('authentication.reset-password');
Route::post('reset-password', [AuthenticationController::class, 'PostResetPassword'])->name('authentication.post.reset-password');
Route::get('register', [AuthenticationController::class, 'Register'])->name('authentication.register');
Route::post('register', [AuthenticationController::class, 'PostRegister'])->name('authentication.post.register');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthenticationController::class, 'Logout'])->name('authentication.logout');

    // change status of product category
    Route::post('change-status-pcategory/{category_id}', [ProductCategoryController::class, 'status'])->name('change.status.pcategory');

    Route::resource('products', ProductController::class);
    Route::resource('product_category', ProductCategoryController::class);

    Route::get('/add-to-cart/{product_id}/{user_id}', [CartController::class, 'addToCart'])->name('add.to.cart');

    Route::get('/cart-items', [CartController::class, 'index'])->name('cart');
    // delete cart item
    Route::post('/delete-cart-item/{id}', [CartController::class, 'deleteCartItem'])->name('cart.remove');
    // update quantity in cart
    Route::patch('/quantity-update', [CartController::class, 'quantityUpdate'])->name('cart.update');
    // check out
    Route::post('/check_out', [CheckOutController::class, 'checkOut'])->name('check.out');
    // transaction
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::post('/transaction', [TransactionController::class, 'search'])->name('transaction.search');
});
