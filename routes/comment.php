<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
    Route::get('index/{article}', [CommentController::class, 'index'])->name('index')->withoutMiddleware('auth:sanctum');
    Route::get('all', [CommentController::class, 'all'])->name('all');
    Route::get('null_count', [CommentController::class, 'null_count'])->name('null_count');
    Route::post('store/{article}/{comment?}', [CommentController::class, 'store'])->name('store')->withoutMiddleware('auth:sanctum');
    Route::put('change_status/{id}/{status}', [CommentController::class, 'change_status'])->name('change_status');
    Route::delete('destroy', [CommentController::class, 'destroy'])->name('destroy');
});
