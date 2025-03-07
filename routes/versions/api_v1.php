<?php

use App\Http\Controllers\Api\v1\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/health-check', function () {
        return response()->json(['status' => 'API v1 OK']);
    });
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    Route::apiResource('users', UsersController::class)->except('update');
});
