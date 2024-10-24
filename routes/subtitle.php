<?php

use App\Http\Controllers\SubtitleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'subtitle', 'as' => 'subtitle.'], function () {
    Route::get('index', [SubtitleController::class, 'index'])->name('index');
    Route::post('store', [SubtitleController::class, 'store'])->name('store');
    Route::delete('destroy', [SubtitleController::class, 'destroy'])->name('destroy');
});
