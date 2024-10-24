<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
    Route::get('index/{category?}', [CategoryController::class, 'index'])->name('index')->withoutMiddleware('auth:sanctum');
    Route::post('store', [CategoryController::class, 'store'])->name('store');
    Route::put('update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('destroy', [CategoryController::class, 'destroy'])->name('destroy');
});
