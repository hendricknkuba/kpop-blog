<?php
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/health-check', function () {
        return response()->json(['status' => 'API v1 OK']);
    });
});
