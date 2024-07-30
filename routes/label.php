<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabelController;

Route::group(['prefix' => 'labels', 'as' => 'labels.'], function () {
    Route::get('index', [LabelController::class, 'index'])->name('index');
    Route::post('sync/{id}', [LabelController::class, 'sync'])->name('sync');
});
