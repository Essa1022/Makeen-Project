<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
    Route::get('index', [RoleController::class, 'index'])->name('index');
    Route::post('store', [RoleController::class, 'store'])->name('store');
    Route::delete('destroy/{id}', [RoleController::class, 'destroy'])->name('destroy');
    Route::post('update_user_roles/{id}', [RoleController::class, 'update_user_roles'])->name('update_user_roles');
    Route::post('update_role_permissions/{id}', [RoleController::class, 'update_role_permissions'])->name('update_role_permissions');
    Route::post('update_user_permissions/{id}', [RoleController::class, 'update_user_permissions'])->name('update_user_permissions');
});
Route::get('permissions/index', [RoleController::class, 'permissions_index'])->name('permissions.index')->middleware('auth:sanctum');
