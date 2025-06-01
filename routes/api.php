<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\BuildingController;

Route::middleware('api.key')->group(function () {
    Route::get('/organizations/building/{buildingId}', [OrganizationController::class, 'byBuilding']);
    Route::get('/organizations/activity/{activityId}', [OrganizationController::class, 'byActivity']);
    Route::get('/organizations/area', [OrganizationController::class, 'byArea']);
    Route::get('/organizations/{id}', [OrganizationController::class, 'show']);
    Route::get('/organizations/search', [OrganizationController::class, 'byName']);
    Route::get('/buildings', [BuildingController::class, 'index']);
});

Route::get('/api/documentation', [L5Swagger\Http\Controllers\SwaggerController::class, 'index']);
