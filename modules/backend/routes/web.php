<?php

use Illuminate\Support\Facades\Route;
use Modules\Backend\Http\Controller\AddressController;
use Modules\Backend\Http\Controller\CategoryController;
use Modules\Backend\Http\Controller\LoginController;
use Modules\Backend\Http\Controller\MainAdminController;
use Modules\Backend\Http\Controller\ProductController;
use Modules\Backend\Http\Controller\UserController;

Route::middleware(['web'])->prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('admin-login');
    Route::post('/login', [LoginController::class, 'store'])->name('admin-store-login');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin-store-logout');

    Route::get('/districts/{cityCode}', [AddressController::class, 'getDistricts'])->name('admin-get-districts');
    Route::get('/wards/{districtCode}', [AddressController::class, 'getWards'])->name('admin-get-wards');
    Route::post('/uploadAvatar/{id}', [UserController::class, 'upAvatar'])->name('admin-up-avatar');
    
    Route::middleware(['role:ROLE_SUPER_ADMIN'])->group(function () {
        Route::get('/dashboard', [MainAdminController::class, 'index'])->name('admin-dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('admin-user');
        Route::get('/products', [ProductController::class, 'index'])->name('admin-product-index');
        
        Route::prefix('user')->group(function () {
            Route::post('/create', [UserController::class, 'create'])->name('admin-user-create');
            Route::get('/delete/{id}', [UserController::class, 'deleted'])->name('admin-user-delete');
            Route::get('/lock/{id}', [UserController::class, 'userState'])->name('admin-user-state');
            Route::get('/edit/{id}', [UserController::class, 'editUser'])->name('admin-user-edit');
            Route::post('/changepassword/{id}', [UserController::class, 'changePassword'])->name('admin-user-change-password');
            Route::post('/save/{id}', [UserController::class, 'saveEditUser'])->name('admin-user-save-edit');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin-category-index');
            Route::post('/add', [CategoryController::class, 'create'])->name('admin-category-store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin-category-edit');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('admin-category-update');

        });

        Route::prefix('products')->group(function () {
            Route::post('/create', [ProductController::class, 'create'])->name('admin-product-create');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin-product-edit');
            Route::post('/imgThumnail/{id}', [ProductController::class, 'upThumbnail'])->name('admin-product-imgThumbnail');
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('admin-product-update');

            
        });
    });
});




