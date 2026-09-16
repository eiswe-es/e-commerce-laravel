<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\ShopController;

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

Route::get('/', [ShopController::class, 'index'])->name('shop');
Route::get('cart', [ShopController::class, 'cart'])->name('cart');
Route::post('cart', [ShopController::class, 'updateCart'])->name('cart.update');
Route::post('cart/{product}', [ShopController::class, 'addToCart'])->name('cart.add');
Route::delete('cart/{product}', [ShopController::class, 'removeFromCart'])->name('cart.remove');

Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard');
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::middleware('auth')->group(function () {
    Route::get('checkout', [ShopController::class, 'checkout'])->name('checkout');
    Route::post('checkout', [ShopController::class, 'placeOrder'])->name('checkout.place');
    Route::get('orders', [ShopController::class, 'orders'])->name('orders');
});





