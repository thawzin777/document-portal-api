<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/auth/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/profile', [App\Http\Controllers\Api\AuthController::class, 'profile']);
    Route::post('/auth/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/documents', [App\Http\Controllers\Api\DocumentController::class, 'index']);
    Route::post('/documents', [App\Http\Controllers\Api\DocumentController::class, 'store']);
    Route::get('/documents/{id}', [App\Http\Controllers\Api\DocumentController::class, 'show']);
    Route::delete('/documents/{id}', [App\Http\Controllers\Api\DocumentController::class, 'destroy']);


    Route::middleware('admin')->group(function () {
    Route::get('/users', [App\Http\Controllers\Api\UserController::class, 'index']);
    Route::get('/users/{id}', [App\Http\Controllers\Api\UserController::class, 'show']);
    Route::post('/users', [App\Http\Controllers\Api\UserController::class, 'store']);
    Route::put('/users/{id}', [App\Http\Controllers\Api\UserController::class, 'update']);
    Route::delete('/users/{id}', [App\Http\Controllers\Api\UserController::class, 'destroy']);
});
});


