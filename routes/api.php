<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\FamilyController;
use App\Http\Controllers\Api\GraveController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ShopController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::patch('notifications/fcm-token', [NotificationController::class, 'updateFcmToken']);

        Route::apiResource('buildings', BuildingController::class);
        Route::apiResource('apartments', ApartmentController::class);
        Route::apiResource('families', FamilyController::class);

        Route::apiResource('shops', ShopController::class);
        Route::apiResource('graves', GraveController::class);
        Route::apiResource('complaints', ComplaintController::class);
    });
});
