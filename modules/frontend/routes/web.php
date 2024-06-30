<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controller\CouponController;
use Modules\Backend\Http\Controller\MainAdminController;
use Modules\Frontend\Http\Controller\AboutController;
use Modules\Frontend\Http\Controller\BlogController;
use Modules\Frontend\Http\Controller\CartFrontendController;
use Modules\Frontend\Http\Controller\ContactController;
use Modules\Frontend\Http\Controller\EditpasswordController;
use Modules\Frontend\Http\Controller\ForgotpassController;
use Modules\Frontend\Http\Controller\LoginController;
use Modules\Frontend\Http\Controller\MainFrontendController;
use Modules\Frontend\Http\Controller\ProfileController;
use Modules\Frontend\Http\Controller\RegisterController;
use Modules\Frontend\Http\Controller\ShopFrontendController;

Route::middleware('web')->group(function () {
    Route::get('/', [MainFrontendController::class, 'index'])->name('home');
    Route::get('/search', [MainFrontendController::class, 'search']);
    Route::get('/shop', [ShopFrontendController::class, 'index'])->name('shop');
    Route::get('/productdetail/{id}', [ShopFrontendController::class, 'detail'])->name('detail');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::post('/profile', [ProfileController::class, 'updateprofile']);

    Route::post('/uploadAvatar/{id}', [ProfileController::class, 'upAvatar']);

    Route::get('/editpassword', [EditpasswordController::class, 'editpassword']);
    Route::post('/editpassword', [EditpasswordController::class, 'updatepassword']);

    Route::get('/viewcart', [CartFrontendController::class, 'view']);
    Route::get('/add/{product}', [CartFrontendController::class, 'addToCart']);
    Route::get('/cart/delete/{id}', [CartFrontendController::class, 'deleteCartItem']);
    Route::post('/cart/update-quantity/{cartItemId}/{quantity}', [CartFrontendController::class, 'updateQuantity'])->name('cart.updateQuantity');

    Route::get('/checkout-2', [CartFrontendController::class, 'checkout_2']);

    Route::get('/userfavorite', [CartFrontendController::class, 'favorite']);
    Route::get('/addfavorite/{id}', [CartFrontendController::class, 'addfavorite']);
    Route::get('/checkVoucher', [CouponController::class, 'check'])->name('user-check-coupon');

    Route::middleware(['role:ROLE_SUPER_ADMIN'])->group(function () {
        Route::get('/dashboard', [MainAdminController::class, 'index'])->name('admin-dashboard');
    });
});




Route::get('/contact', [ContactController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/blog', [BlogController::class, 'index']);
