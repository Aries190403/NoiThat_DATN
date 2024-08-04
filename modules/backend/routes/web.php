<?php

use Illuminate\Support\Facades\Route;
use Modules\Backend\Http\Controller\AddressController;
use Modules\Backend\Http\Controller\CategoryController;
use Modules\Backend\Http\Controller\CouponController;
use Modules\Backend\Http\Controller\FeedbackController;
use Modules\Backend\Http\Controller\InvoiceController;
use Modules\Backend\Http\Controller\LoginController;
use Modules\Backend\Http\Controller\MainAdminController;
use Modules\Backend\Http\Controller\MaterialController;
use Modules\Backend\Http\Controller\ProductController;
use Modules\Backend\Http\Controller\SettingController;
use Modules\Backend\Http\Controller\StatisticalController;
use Modules\Backend\Http\Controller\SupplierController;
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
            Route::get('/deleted/{id}', [CategoryController::class, 'deleted'])->name('admin-category-deleted');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('admin-category-update');
        });

        Route::prefix('products')->group(function () {
            Route::post('/create', [ProductController::class, 'create'])->name('admin-product-create');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin-product-edit');
            Route::post('/imgThumbnail/{id}', [ProductController::class, 'upThumbnail'])->name('admin-product-imgThumbnail');
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('admin-product-update');

            Route::post('/uploadimgs/{id}', [ProductController::class, 'uploadImages'])->name('admin-product-upload-imgs');
            Route::post('/delimg/{id}', [ProductController::class, 'deleteImage'])->name('admin-product-del-img');
            Route::get('/lock/{id}', [ProductController::class, 'productState'])->name('admin-product-state');
            Route::get('/deleteProd/{id}', [ProductController::class, 'deleteProduct'])->name('admin-product-del');
            Route::post('/importing/{id}', [ProductController::class, 'importing'])->name('admin-product-importing');
            Route::get('/detailLog/{id}', [ProductController::class, 'detailLog'])->name('admin-product-detailLogs');
            Route::post('/importProducts', [ProductController::class, 'importProducts'])->name('admin-product-importProducts');
        });

        Route::prefix('material')->group(function () {
            Route::get('/', [MaterialController::class, 'index'])->name('admin-material-index');
            Route::post('/add', [MaterialController::class, 'create'])->name('admin-material-store');
            Route::get('/edit/{id}', [MaterialController::class, 'edit'])->name('admin-material-edit');
            Route::post('/update/{id}', [MaterialController::class, 'update'])->name('admin-material-update');
            Route::get('/deleted/{id}', [MaterialController::class, 'deleted'])->name('admin-material-deleted');
        });

        Route::prefix('coupon')->group(function () {
            Route::get('/', [CouponController::class, 'index'])->name('admin-coupon-index');
            Route::post('/create', [CouponController::class, 'create'])->name('admin-coupon-create');
            Route::post('/state/{id}', [CouponController::class, 'couponState'])->name('admin-coupon-state');
            Route::get('/view/{id}', [CouponController::class, 'view'])->name('admin-coupon-view');
            Route::post('/update/{id}', [CouponController::class, 'update'])->name('admin-coupon-update');
        });

        Route::prefix('setting')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('admin-setting-index');
            Route::post('/change', [SettingController::class, 'change'])->name('admin-setting-change');
            Route::post('/addImage', [SettingController::class, 'addImage'])->name('admin-setting-addImage');
            Route::post('/admin-setting-editImage', [SettingController::class, 'editImage'])->name('admin-setting-editImage');
            Route::post('/admin-setting-deleteImage', [SettingController::class, 'deleteImage'])->name('admin-setting-deleteImage');
            Route::post('/update-lock-status', [SettingController::class, 'updateLockStatus'])->name('admin-setting-update-lock-status');
        });

        Route::prefix('supplier')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('admin-supplier-index');
            Route::post('/create', [SupplierController::class, 'Create'])->name('admin-supplier-create');
            Route::get('/information/{id}', [SupplierController::class, 'getInfor'])->name('admin-supplier-infor');
            Route::post('/edit/{id}', [SupplierController::class, 'edit'])->name('admin-supplier-edit');
            Route::post('/state/{id}', [SupplierController::class, 'couponState'])->name('admin-supplier-state');
            Route::post('/uplogo/{id}', [SupplierController::class, 'upAvatar'])->name('admin-supplier-uplogo');
        });

        Route::prefix('invoice')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('admin-invoice-index');
            Route::post('/update', [InvoiceController::class, 'update'])->name('admin-invoice-update');
            Route::get('/detail/{id}', [InvoiceController::class, 'detail'])->name('admin-invoice-detail');
            Route::post('/split', [InvoiceController::class, 'splip'])->name('admin-invoice-splip');
            Route::post('/cancel/{id}', [InvoiceController::class, 'cancel'])->name('admin-invoice-cancel');
        });

        Route::prefix('statistical')->group(function () {
            Route::get('/', [StatisticalController::class, 'index'])->name('admin-statistical-index');
        });

        Route::prefix('feedback')->group(function () {
            Route::get('/', [FeedbackController::class, 'index'])->name('admin-feedback-index');
            Route::post('/lock/{id}', [FeedbackController::class, 'State'])->name('admin-feedback-state');
            Route::get('/view/{id}', [FeedbackController::class, 'view'])->name('admin-feedback-view');
        });
    });
});
Route::get('/errorDevtools', [MainAdminController::class, 'blockDevTools']);
