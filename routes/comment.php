<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
    Route::get('index/{article?}', [CommentController::class, 'index'])->name('index')->withoutMiddleware('auth:sanctum');
    Route::post('store/{id?}/{article}', [CommentController::class, 'store'])->name('store')->withoutMiddleware('auth:sanctum');
    Route::put('update/{id}', [CommentController::class, 'update'])->name('update');
});
