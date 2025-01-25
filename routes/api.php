<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ReservationController;

Route::prefix('pricing')->group(function () {
    Route::get('/', [PricingController::class, 'index']);
});

Route::prefix('reservation')->group(function () {
    Route::post('/', [ReservationController::class, 'store']);
});