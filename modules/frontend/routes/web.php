<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controller\CouponController;
use Modules\Backend\Http\Controller\MainAdminController;
use Modules\Frontend\Http\Controller\AboutController;
use Modules\Frontend\Http\Controller\BlogController;
use Modules\Frontend\Http\Controller\CartFrontendController;
use Modules\Frontend\Http\Controller\CategoryController;
use Modules\Frontend\Http\Controller\ContactController;
use Modules\Frontend\Http\Controller\EditpasswordController;
use Modules\Frontend\Http\Controller\ForgotpassController;
use Modules\Frontend\Http\Controller\LoginController;
use Modules\Frontend\Http\Controller\MainFrontendController;
use Modules\Frontend\Http\Controller\OrderController;
use Modules\Frontend\Http\Controller\ProfileController;
use Modules\Frontend\Http\Controller\RateController;
use Modules\Frontend\Http\Controller\RegisterController;
use Modules\Frontend\Http\Controller\RoomController;
use Modules\Frontend\Http\Controller\ShopFrontendController;
use Modules\Frontend\Http\Controller\VnPayController;

Route::middleware('web')->group(function () {
    Route::get('/', [MainFrontendController::class, 'index'])->name('home');
    Route::get('/search', [MainFrontendController::class, 'search']);
    Route::get('/shop', [ShopFrontendController::class, 'index'])->name('shop');
    Route::get('/productdetail/{id}', [ShopFrontendController::class, 'detail'])->name('detail');
    Route::post('/filter-products', [ShopFrontendController::class, 'filterProducts']);
    Route::get('/filter-products', [RateController::class, 'notfound']);
    Route::post('/filter-category', [CategoryController::class, 'index']);
    Route::get('/filter-category', [RateController::class, 'notfound']);

    Route::get('/room/{id}', [RoomController::class, 'index']);
    Route::post('/filter-roomproducts/{id}', [RoomController::class, 'filterroomProducts']);
    Route::get('/filter-roomproducts/{id}', [RateController::class, 'notfound']);

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/logout', [RateController::class, 'notfound']);

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout']);
        Route::middleware(['role:USER'])->group(function () {
            Route::get('/profile', [ProfileController::class, 'profile']);
            Route::post('/profile', [ProfileController::class, 'updateprofile']);

            Route::get('/userorderlist', [OrderController::class, 'index']);

            Route::post('/filter-invoices', [OrderController::class, 'filterInvoices']);
            Route::get('/filter-invoices', [RateController::class, 'notfound']);

            Route::get('/repay/{id}', [OrderController::class, 'repay']);
            Route::get('/vieworder', [OrderController::class, 'view'])->name('vieworder');
            Route::get('/viewmore/{id}', [OrderController::class, 'viewmore']);
            Route::get('/cancel/{id}', [OrderController::class, 'cancel']);
            Route::get('/return/{id}', [OrderController::class, 'return']);

            Route::post('/rate/{invoiceId}', [RateController::class, 'store'])->name('rate.store');
            Route::get('/rate/{invoiceId}', [RateController::class, 'notfound']);

            Route::post('/uploadAvatar/{id}', [ProfileController::class, 'upAvatar']);
            Route::get('/uploadAvatar/{id}', [RateController::class, 'notfound']);

            Route::get('/editpassword', [EditpasswordController::class, 'editpassword']);
            Route::post('/editpassword', [EditpasswordController::class, 'updatepassword']);

            Route::get('/viewcart', [CartFrontendController::class, 'view']);
            Route::get('/buynow/{id}', [CartFrontendController::class, 'buynow']);
            Route::get('/add/{product}', [CartFrontendController::class, 'addToCart']);
            Route::get('/cart/delete/{id}', [CartFrontendController::class, 'deleteCartItem']);
            Route::post('/cart/update-quantity/{cartItemId}/{quantity}', [CartFrontendController::class, 'updateQuantity'])->name('cart.updateQuantity');
            Route::get('/cart/update-quantity/{cartItemId}/{quantity}', [RateController::class, 'notfound']);

            Route::get('/checkout-2', [CartFrontendController::class, 'checkout_2']);
            Route::post('/checkout-3', [CartFrontendController::class, 'checkout_3']);
            Route::get('/checkout-3', [RateController::class, 'notfound']);

            Route::get('/receipt', [CartFrontendController::class, 'receipted'])->name('receipt');
            Route::get('/pay', [CartFrontendController::class, 'pay']);

            Route::get('/userfavorite', [CartFrontendController::class, 'favorite']);
            Route::get('/addfavorite/{id}', [CartFrontendController::class, 'addfavorite']);
            Route::get('/checkVoucher', [CouponController::class, 'check'])->name('user-check-coupon');
        });
        Route::middleware(['role:ROLE_SUPER_ADMIN'])->group(function () {
            Route::get('/dashboard', [MainAdminController::class, 'index'])->name('admin-dashboard');
        });
    });
});




Route::get('/contact', [ContactController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/blog', [BlogController::class, 'index']);
