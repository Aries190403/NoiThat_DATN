<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controller\MainFrontendController;

Route::get('/', [MainFrontendController::class, 'index'])->name('home');



