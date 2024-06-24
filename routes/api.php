<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * Version 1
 */
Route::prefix('v1')->as('v1:')->group(
    base_path('routes/v1/api.php'),
);

/*
 * Version 2
 *
 */



Route::prefix('v1')->middleware(['treblle', 'throttle:api'])->group(function () {
    Route::post('/convert', [\App\Http\Controllers\Api\v1\ConversionController::class, 'convert']);
    Route::get('/recent-conversions', [\App\Http\Controllers\Api\v1\ConversionController::class, 'recentConversions']);
    Route::get('/top-conversions', [\App\Http\Controllers\Api\v1\ConversionController::class, 'topConversions']);
});
