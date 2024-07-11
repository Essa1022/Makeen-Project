<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
    Route::get('index', [CategoryController::class, 'index'])->name('index')->withoutMiddleware('auth:sanctum');
    Route::post('store', [CategoryController::class, 'store'])->name('store');
    Route::delete('destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});
