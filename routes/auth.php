<?php

use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login'])->name('login')->withoutMiddleware('auth:sanctum');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('forgot_password', [PasswordResetController::class, 'forgot_password'])->name('forgot.password')->withoutMiddleware('auth:sanctum');
Route::post('verify_code', [PasswordResetController::class, 'verify_code'])->name('verify.code')->withoutMiddleware('auth:sanctum');
Route::post('reset_password', [PasswordResetController::class, 'reset_password'])->name('reset.password')->withoutMiddleware('auth:sanctum');

