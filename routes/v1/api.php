<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['treblle'])->group(function () {
    Route::post('/convert', [\App\Http\Controllers\Api\v1\ConversionController::class, 'convert']);
    Route::get('/recent-conversions', [\App\Http\Controllers\Api\v1\ConversionController::class, 'recentConversions']);
    Route::get('/top-conversions', [\App\Http\Controllers\Api\v1\ConversionController::class, 'topConversions']);
});
