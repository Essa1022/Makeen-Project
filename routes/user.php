<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('index', [UserController::class, 'index'])->name('index');
    Route::get('show/{id}', [UserController::class, 'show'])->name('show');
    Route::post('store', [UserController::class, 'store'])->name('store');
    Route::put('change_status/{id}', [UserController::class, 'change_status'])->name('change_status');
});
    Route::get('show_profile', [UserController::class, 'show_profile'])->name('show_profile');
    Route::put('update_profile', [UserController::class, 'update_profile'])->name('update_profile');
    Route::put('change_password', [UserController::class, 'change_password'])->name('change_password');

