<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabelController;

    Route::get('label/index', [LabelController::class, 'index'])->name('label.index');

