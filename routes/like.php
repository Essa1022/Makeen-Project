<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;

    Route::post('like/{comment}', [LikeController::class, 'like'])->name('like')->withoutMiddleware('auth:sanctum');

