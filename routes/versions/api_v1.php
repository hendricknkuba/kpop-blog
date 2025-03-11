<?php

use App\Http\Controllers\Api\v1\PostsController;
use App\Http\Controllers\Api\v1\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/health-check', function () {
        return response()->json(['status' => 'API v1 OK']);
    });
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('users', UsersController::class)->except('update');
    Route::put('users/{user}', [UsersController::class, 'replace']);
    Route::patch('users/{user}', [UsersController::class, 'update']);

    Route::apiResource('posts', PostsController::class)->except('update');
    Route::put('posts/{post}', [PostsController::class, 'replace']);
    Route::patch('posts/{post}', [PostsController::class, 'update']);
});
