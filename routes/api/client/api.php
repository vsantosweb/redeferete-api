<?php

use App\Http\Controllers\Api\Client\Driver\Auth\DriverAuthController;
use App\Http\Controllers\Api\Client\Driver\Auth\DriverPasswordRecoveryController;
use App\Http\Controllers\Api\Client\Driver\DriverPartnerController;
use App\Http\Controllers\Api\Client\Driver\DriverVehicleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| driver Routes
|--------------------------------------------------------------------------
|
| Here is where you can register driver routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('drivers')->group(function () {
    Route::prefix('auth')->namespace('Auth')->group(function () {
        Route::prefix('register')->group(function () {
            Route::post('/', [DriverAuthController::class, 'preRegister']);
            Route::post('/complete', [DriverAuthController::class, 'completeRegister']);
            Route::get('/verify', [DriverAuthController::class, 'verify']);
        });

        Route::prefix('password')->group(function () {
            Route::post('recovery-request', [DriverPasswordRecoveryController::class, 'recoveryRequest']);
            Route::post('validate-recovery-request', [DriverPasswordRecoveryController::class, 'validateRecoveryRequest']);
            Route::post('recovery', [DriverPasswordRecoveryController::class, 'recovery']);
        });

        Route::post('login', [DriverAuthController::class, 'login']);
        // Route::post('email/verify', 'DriverVerificationController@verify');
        // Route::post('email/resend', 'DriverVerificationController@resend');

        Route::middleware('auth:driver')->group(function () {
            Route::post('logout', [DriverAuthController::class, 'logout']);
            Route::get('session', [DriverAuthController::class, 'session']);
        });
    });

    Route::middleware(['auth:driver'/*emailVerified */])->group(function () {
        Route::apiResource('vehicles', DriverVehicleController::class);

        Route::prefix('partners')->group(function () {
            Route::get('/', [DriverPartnerController::class, 'partnerVehicles']);
            Route::post('invite', [DriverPartnerController::class, 'invitePartner']);
            Route::put('invite/{uuid}', [DriverPartnerController::class, 'inviteAction']);
        });

        Route::post('live-search', [DriverPartnerController::class, 'liveSearch']);
        Route::post('send-invitation-partner', [DriverPartnerController::class, 'sendInvitationPartner']);
        Route::get('my-invites', [DriverPartnerController::class, 'getInvites']);
    });
});
