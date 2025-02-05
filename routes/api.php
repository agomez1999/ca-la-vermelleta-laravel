<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;

Route::prefix('pricing')->group(function () {
    Route::get('/', [PricingController::class, 'index']);
    Route::post('/', [PricingController::class, 'store']);
});

Route::prefix('reservation')->group(function () {
    Route::post('/', [ReservationController::class, 'store']);
    Route::get('calendar-data', [ReservationController::class, 'getCalendarData']);
});

Route::prefix('user')->group(function () {
    Route::middleware('auth:sanctum')->get('/verify-token', [UserController::class, 'verifyToken']);
    Route::post('/register', [UserController::class, 'store']);
    Route::post('/login', [UserController::class, 'login']);
});