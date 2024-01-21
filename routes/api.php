<?php

use App\Http\Controllers\Api\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/surveys', [SurveyController::class, 'index']);
        Route::post('register', [AuthController::class, 'register']);
    });

    Route::middleware(['role:alumni'])->group(function () {
        Route::get('/surveys/{id}', [SurveyController::class, 'show']);
        Route::post('/surveys', [SurveyController::class, 'store']);
        Route::put('/surveys/{id}', [SurveyController::class, 'update']);
        Route::delete('/surveys/{id}', [SurveyController::class, 'destroy']);
    });
});