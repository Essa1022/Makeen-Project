<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function(){
require __DIR__ . '/user.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/label.php';
require __DIR__ . '/article.php';
require __DIR__ . '/comment.php';
require __DIR__ . '/role.php';
require __DIR__ . '/category.php';
require __DIR__ . '/media.php';
require __DIR__ . '/like.php';
require __DIR__ . '/subtitle.php';
});
