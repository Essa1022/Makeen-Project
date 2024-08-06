<?php


use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'articles', 'as' => 'articles.'], function () {
    Route::get('filter/{category?}', [ArticleController::class, 'filter'])->name('filter')->withoutMiddleware('auth:sanctum');
    Route::get('index/{category?}', [ArticleController::class, 'index'])->name('index')->withoutMiddleware('auth:sanctum');
    Route::get('all', [ArticleController::class, 'all'])->name('all');
    Route::get('show/{slug}', [ArticleController::class, 'show'])->name('show')->withoutMiddleware('auth:sanctum');
    Route::post('store', [ArticleController::class, 'store'])->name('store');
    Route::put('update/{id}', [ArticleController::class, 'update'])->name('update');
    Route::put('change_status/{id}/{status}', [ArticleController::class, 'change_status'])->name('change_status');
    Route::delete('destroy', [ArticleController::class, 'destroy'])->name('destroy');
});
