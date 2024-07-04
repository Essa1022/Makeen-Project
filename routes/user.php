<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('index', [UserController::class, 'index'])->name('index');
    Route::get('show/{id}', [UserController::class, 'show'])->name('show');
    Route::post('store', [UserController::class, 'store'])->name('store');
    Route::put('update/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('destroy', [UserController::class, 'destroy'])->name('destroy');
    route::get('me', [UserController::class , 'me'])->name('me');
});
