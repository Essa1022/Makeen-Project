<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabelController;

    Route::get('labels/index', [LabelController::class, 'index'])->name('labels.index');

