<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API маршрути - GET заявки от NEXT.js фронтенд
Route::prefix('categories')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\CategoryController::class, 'index']);
    Route::get('/{category}', [\App\Http\Controllers\Api\CategoryController::class, 'show']);
});

Route::prefix('services')->group(function () {
    Route::get('/{categoryId}', [\App\Http\Controllers\Api\ServiceController::class, 'index']);
});