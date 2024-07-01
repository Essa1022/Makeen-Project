<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login'])->name('login')->withoutMiddleware('auth:sanctum');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('check_phone_number', [AuthController::class, 'check_phone_number'])->name('check_phone_number')->withoutMiddleware('auth:sanctum');
Route::post('check_code', [AuthController::class, 'check_code'])->name('check_code')->withoutMiddleware('auth:sanctum');
Route::post('reset_password', [AuthController::class, 'reset_password'])->name('reset_password')->withoutMiddleware('auth:sanctum');

