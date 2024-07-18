<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabelController;

Route::group(['prefix' => 'labels', 'as' => 'labels.'], function () {
    Route::get('index', [LabelController::class, 'index'])->name('index');
    Route::post('store', [LabelController::class, 'store'])->name('store');
    Route::delete('destroy', [LabelController::class, 'destroy'])->name('destroy');
    Route::post('sync/{id}', [LabelController::class, 'sync'])->name('sync');
});
