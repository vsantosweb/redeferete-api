<?php

use App\Http\Controllers\Api\PreRegistrationController;
use App\Http\Controllers\Api\Private\Driver\DriverBankController;
use App\Http\Controllers\Api\Private\Driver\DriverContractController;
use App\Http\Controllers\Api\Private\Driver\DriverController;
use App\Http\Controllers\Api\Private\Driver\DriverDocumentController;
use App\Http\Controllers\Api\Private\Driver\DriverLicenceController;
use App\Http\Controllers\Api\Private\Driver\DriverVehicleController;
use App\Http\Controllers\Api\Private\User\Auth\UserAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Private Routes
|--------------------------------------------------------------------------
|
| Here is where you can register driver routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('user/auth')->group(function () {
    Route::post('login', [UserAuthController::class, 'login']);

    Route::middleware('auth:user')->group(function () {
        Route::post('logout', [UserAuthController::class, 'logout']);
        Route::get('session', [UserAuthController::class, 'session']);
    });
});

Route::middleware('auth:user')->group(function () {
    Route::prefix('drivers')->group(function () {
        Route::get('/', [DriverController::class, 'index']);
        Route::get('/{id}', [DriverController::class, 'show']);
        Route::post('/', [DriverController::class, 'store']);
        Route::patch('/{id}', [DriverController::class, 'update']);
        Route::delete('/{id}', [DriverController::class, 'destroy']);
        Route::put('{id}/change-status', [DriverController::class, 'changeStatus']);

        Route::patch('{id}/licence', [DriverDocumentController::class, 'makeLicence']);
        Route::patch('{id}/address', [DriverDocumentController::class, 'makeAddress']);

        Route::apiResource('{id}/banks', DriverBankController::class);
        Route::apiResource('{id}/vehicles', DriverVehicleController::class);

        Route::put('{id}/licence/change-status', [DriverLicenceController::class, 'changeLicenceStatus']);

        Route::get('/overview/range-date', [DriverController::class, 'getDriversByDateRange']);
        Route::get('hubs/overview/range-date', [DriverController::class, 'getDriversHubsByDateRange']);
    });

    Route::apiResource('driver-contracts', DriverContractController::class);

    Route::get('capture-leads', [PreRegistrationController::class, 'index']);
    Route::get('/driver-statuses', [DriverController::class, 'status']);
});
