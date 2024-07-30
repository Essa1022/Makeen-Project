<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('category/index/{category?}', [CategoryController::class, 'index'])->name('category.index')->withoutMiddleware('auth:sanctum');
