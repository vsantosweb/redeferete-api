<?php

use App\Http\Controllers\Api\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('vehicle-types', [PublicController::class, 'getVehicleTypes']);
Route::get('licence-categories', [PublicController::class, 'getLicenceCategories']);
Route::get('check-vehicle-exists/{licence_plate}', [PublicController::class, 'checkVehicleExists']);
Route::get('avaiable-driver-hub/{address}', [PublicController::class, 'checkDriverAvaiableHub']);
