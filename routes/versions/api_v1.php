<?php

use App\Http\Controllers\Api\v1\CommentsController;
use App\Http\Controllers\Api\v1\PostsController;
use App\Http\Controllers\Api\v1\UserPostsController;
use App\Http\Controllers\Api\v1\UsersController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::prefix('v1')->group(function () {
    Route::get('/health-check', function () {
        return response()->json(['status' => 'API v1 OK']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    Route::apiResource('users', UsersController::class)->except('update');
    Route::put('users/{user}', [UsersController::class, 'replace']);
    Route::patch('users/{user}', [UsersController::class, 'update']);

    Route::apiResource('posts', PostsController::class)->except('update');
    Route::put('posts/{post}', [PostsController::class, 'replace']);
    Route::patch('posts/{post}', [PostsController::class, 'update']);

    Route::apiResource('users.posts', UserPostsController::class)->except('update');
    Route::put('users/{user}/posts/{post}', [UserPostsController::class, 'replace']);
    Route::patch('users/{user}/posts/{post}', [UserPostsController::class, 'update']);

    Route::apiResource('comments', CommentsController::class);
});
