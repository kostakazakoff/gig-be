<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API маршрути - GET заявки от NEXT.js фронтенд
Route::middleware('locale')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\CategoryController::class, 'index']);
        Route::get('/{category}', [\App\Http\Controllers\Api\CategoryController::class, 'show']);
    });

    Route::prefix('services')->group(function () {
        Route::get('/{categoryId}', [\App\Http\Controllers\Api\ServiceController::class, 'index']);
    });

    Route::prefix('locale')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\LocaleController::class, 'getLocale']);
        Route::post('/', [\App\Http\Controllers\Api\LocaleController::class, 'switch']);
    });

    Route::prefix('projects')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\ProjectController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Api\ProjectController::class, 'show']);
    });

    Route::prefix('news')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\NewsController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Api\NewsController::class, 'show']);
    });

    Route::post('/inquiry', [\App\Http\Controllers\Api\InquiryController::class, 'store']);
});