<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/leads', [\App\Http\Controllers\LeadController::class, 'store']);
Route::get('/platform-types/{type}', [\App\Http\Controllers\LeadController::class, 'getPlatforms']);
