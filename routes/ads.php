<?php

use App\Http\Controllers\AdsController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'ad', 'as' => 'ad.'], function () {
    Route::get('index', [AdsController::class, 'index'])->name('index');
    Route::get('show', [AdsController::class, 'show'])->name('show')->withoutMiddleware('auth:sanctom');
    Route::post('store', [AdsController::class, 'store'])->name('store');
    Route::put('update/{id}', [AdsController::class, 'update'])->name('update');
    Route::delete('destroy', [AdsController::class, 'destroy'])->name('destroy');
});

