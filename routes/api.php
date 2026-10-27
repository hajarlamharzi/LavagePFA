<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\ContactController;

Route::prefix('api')->group(function () {
    // Route CSRF
    Route::get('/sanctum/csrf-cookie', function () {
        return response()->json(['message' => 'CSRF cookie set']);
    });

    // Route test
    Route::get('/test', function () {
        return response()->json(['message' => 'API is working']);
    });

    // Routes API pour les réservations
    Route::post('/reservations', [ReservationController::class, 'store']);
    
    // Routes API pour le contact
    Route::post('/contact', [ContactController::class, 'store']);
    
    // Routes protégées (si besoin plus tard)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/reservations', [ReservationController::class, 'index']);
    });
});