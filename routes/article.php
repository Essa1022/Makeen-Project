<?php


use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'articles', 'as' => 'articles.'], function () {
    Route::get('index/{category?}', [ArticleController::class, 'index'])->name('index')->withoutMiddleware('auth:sanctum');
    Route::get('show/{id}', [ArticleController::class, 'show'])->name('show')->withoutMiddleware('auth:sanctum');
    Route::post('store', [ArticleController::class, 'store'])->name('store');
    Route::put('update/{id}', [ArticleController::class, 'update'])->name('update');
    Route::delete('destroy', [ArticleController::class, 'destroy'])->name('destroy');
});
