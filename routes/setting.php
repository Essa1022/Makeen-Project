<?php

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
    Route::get('index', [SettingController::class, 'index'])->name('index');
    Route::get('show/{id}', [SettingController::class, 'show'])->name('show')->withoutMiddleware('auth:sanctum');
    Route::put('update/{id}', [SettingController::class, 'update'])->name('update');
});
