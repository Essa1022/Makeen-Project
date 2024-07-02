<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabelController;

Route::group(['prefix' => 'labels', 'as' => 'labels.'], function () {
    Route::get('index', [LabelController::class, 'index'])->name('index');
    Route::get('show/{id}', [LabelController::class, 'show'])->name('show');
    Route::post('store', [LabelController::class, 'store'])->name('store');
    Route::put('update/{id}', [LabelController::class, 'update'])->name('update');
    Route::delete('destroy', [LabelController::class, 'destroy'])->name('destroy');
    Route::post('sync/{id}', [LabelController::class, 'sync'])->name('sync');
});
