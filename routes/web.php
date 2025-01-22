<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\PricingController;

Route::prefix('pricing')->group(function () {
    Route::get('/', [PricingController::class, 'index']);
});
