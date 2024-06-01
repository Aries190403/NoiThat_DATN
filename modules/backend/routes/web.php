<?php

use Illuminate\Support\Facades\Route;
use Modules\Backend\Http\Controller\AddressController;
use Modules\Backend\Http\Controller\CategoryController;
use Modules\Backend\Http\Controller\LoginController;
use Modules\Backend\Http\Controller\MainAdminController;
use Modules\Backend\Http\Controller\UserController;

// Route::get('/categories', [CategoryController::class, 'index'])->name('category-index');

// Route::get('/categories/add', [CategoryController::class, 'create'])->name('category-create');
// Route::post('/categories/add', [CategoryController::class, 'store'])->name('category-store');

// Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('category-edit');
// Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('category-update');


Route::middleware(['web'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('admin-login');
        Route::post('/login', [LoginController::class, 'store'])->name('admin-store-login');
        Route::get('/logout', [LoginController::class, 'logout'])->name('admin-store-logout');

        Route::get('/districts/{cityCode}', [AddressController::class, 'getDistricts'])->name('admin-get-districts');
        Route::get('/wards/{districtCode}', [AddressController::class, 'getWards'])->name('admin-get-wards');
        Route::post('/uploadAvatar/{id}', [UserController::class, 'upAvatar'])->name('admin-up-avatar');
        
        Route::middleware(['role:ROLE_SUPER_ADMIN'])->group(function () {
            Route::get('/dashboard', [MainAdminController::class, 'index'])->name('admin-dashboard');
            Route::get('/users', [UserController::class, 'index'])->name('admin-user');
            Route::post('/user/create', [UserController::class, 'create'])->name('admin-user-create');
            Route::get('/user/delete/{id}', [UserController::class, 'deleted'])->name('admin-user-delete');
            Route::get('/user/lock/{id}', [UserController::class, 'userState'])->name('admin-user-state');
            Route::get('/user/edit/{id}', [UserController::class, 'editUser'])->name('admin-user-edit');
            Route::post('/user/changepassword/{id}', [UserController::class, 'changePassword'])->name('admin-user-change-password');
            Route::post('/user/save/{id}', [UserController::class, 'saveEditUser'])->name('admin-user-save-edit');

        });
    });
});



