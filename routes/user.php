<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('show', [UserController::class, 'show'])->name('show');
    Route::put('update', [UserController::class, 'update'])->name('update');
});
