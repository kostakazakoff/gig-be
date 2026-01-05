<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('categories')->group(function () {
    Route::get('/', [\App\Http\Controllers\CategoryController::class, 'index']);
    Route::post('/', [\App\Http\Controllers\CategoryController::class, 'store']);
    Route::get('/{category}', [\App\Http\Controllers\CategoryController::class, 'show']);
    Route::put('/{category}', [\App\Http\Controllers\CategoryController::class, 'update']);
    Route::delete('/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy']);
});