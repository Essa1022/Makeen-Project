<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
    Route::get('index', [CommentController::class, 'index'])->name('index');
    Route::get('show/{id}', [CommentController::class, 'show'])->name('show');
    Route::post('store', [CommentController::class, 'store'])->name('store');
    Route::put('update/{id}', [CommentController::class, 'update'])->name('update');
    Route::delete('destroy', [CommentController::class, 'destroy'])->name('destroy');
});
