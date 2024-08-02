<?php

use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login'])->name('login')->withoutMiddleware('auth:sanctum');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('request_reset', [PasswordResetController::class, 'request_reset'])->name('request_reset')->withoutMiddleware('auth:sanctum');
Route::post('verify_code', [PasswordResetController::class, 'verify_code'])->name('verify_code')->withoutMiddleware('auth:sanctum');
Route::post('reset_password', [PasswordResetController::class, 'reset_password'])->name('reset_password')->withoutMiddleware('auth:sanctum');

