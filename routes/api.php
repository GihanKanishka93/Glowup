<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdmissionController;
use App\Http\Controllers\Api\BillingController as ApiBillingController;
use App\Http\Controllers\Api\OccupancyController;
use App\Http\Controllers\Api\PatientController as ApiPatientController;
use App\Http\Controllers\Api\PetController as ApiPetController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\UserPreferenceController;

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

Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user()->loadMissing('roles', 'permissions');
    });

    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);

    Route::patch('preferences/theme', [UserPreferenceController::class, 'updateTheme']);
    Route::patch('preferences/status', [UserPreferenceController::class, 'updateStatus']);

    Route::apiResource('patients', ApiPatientController::class);
    Route::apiResource('pets', ApiPetController::class);
    Route::apiResource('billing', ApiBillingController::class);
    Route::apiResource('admissions', AdmissionController::class);
    Route::apiResource('occupancies', OccupancyController::class);

    Route::prefix('reports')->group(function () {
        Route::get('billing-summary', [ReportController::class, 'billingSummary']);
        Route::get('occupancy-summary', [ReportController::class, 'occupancySummary']);
        Route::get('treatment-followups', [ReportController::class, 'treatmentFollowups']);
    });
});
