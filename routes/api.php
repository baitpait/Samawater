<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DistributorController;
use App\Http\Controllers\Api\DistributorAuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ClientDueController;
use App\Http\Controllers\Api\Allclient;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\DistributorBalanceController;
use App\Http\Controllers\Api\DriverLocationController;

Route::get('/distributor-balance', [DistributorBalanceController::class, 'index']);
Route::get('/distributor-balance/{id}', [DistributorBalanceController::class, 'show']);
Route::post('/upload-image', [ClientController::class, 'uploadImage']);

Route::post('/update-driver-location', [DistributorController::class, 'updateLocation']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/driver/location', [DriverLocationController::class, 'update']);
});

Route::get('/drivers/locations', [DriverLocationController::class, 'index']);


Route::post('/deliveries', [DeliveryController::class, 'store']);
Route::get('/clients-due', [ClientDueController::class, 'index']);
Route::get('/allclient', [Allclient::class, 'index']);

Route::post('update-client-address', [ClientController::class, 'updateAddress']);

Route::post('/update-client-location', [ClientController::class, 'updateLocation']);
Route::post('/distributor/deactivate', [DistributorAuthController::class, 'deactivate']) ->middleware('auth:sanctum');

Route::get('/cities', [CityController::class, 'index']);

Route::post('/distributor/login', [DistributorAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/distributor/logout', [DistributorAuthController::class, 'logout']);

    Route::get('/distributors', [DistributorController::class, 'index']);
    Route::get('/distributors/{id}', [DistributorController::class, 'show']);
    Route::post('/distributors', [DistributorController::class, 'store']);
    Route::put('/distributors/{id}', [DistributorController::class, 'update']);
    Route::delete('/distributors/{id}', [DistributorController::class, 'destroy']);
});