<?php

use Illuminate\Support\Facades\Route;
use Modules\Backend\Http\Controller\MainAdminController;
use Modules\Frontend\Http\Controller\AboutController;
use Modules\Frontend\Http\Controller\BlogController;
use Modules\Frontend\Http\Controller\ContactController;
use Modules\Frontend\Http\Controller\LoginController;
use Modules\Frontend\Http\Controller\MainFrontendController;
use Modules\Frontend\Http\Controller\RegisterController;
use Modules\Frontend\Http\Controller\ShopFrontendController;

Route::middleware('web')->group(function () {
    Route::get('/', [MainFrontendController::class, 'index'])->name('home');
    Route::get('/shop', [ShopFrontendController::class, 'index'])->name('shop');
    Route::get('/productdetail/{id}', [ShopFrontendController::class, 'detail'])->name('detail');

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::post('/logout', [LoginController::class, 'logout']);
    // Route::group(['refix' => 'cart'], function () {
    //     // Route::get('/', [CartFrontendController::class, 'view'])->name('cart.view');
    //     Route::get('/add/{product}', [CartFrontendController::class, 'addtocart']);
    // });
    Route::middleware(['role:ROLE_SUPER_ADMIN'])->group(function () {
        Route::get('/dashboard', [MainAdminController::class, 'index'])->name('admin-dashboard');
    });
});


Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'Store'])->name('register');

Route::get('/contact', [ContactController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/blog', [BlogController::class, 'index']);
