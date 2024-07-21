<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;

Route::group(['prefix' => 'like', 'as' => 'like.'], function () {
    Route::post('store/{comment}', [LikeController::class, 'store'])->name('store');
    Route::put('update/{comment}', [LikeController::class, 'update'])->name('update');
    Route::delete('delete/{comment}', [LikeController::class, 'delete'])->name('delete');
})->withoutMiddleware('auth:sanctum');
