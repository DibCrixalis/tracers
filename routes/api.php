<?php

use App\Http\Controllers\Api\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContinueStudyController;
use App\Http\Controllers\Api\EntrepreneurshipController;
use App\Http\Controllers\Api\WorkController;

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
        Route::post('register', [AuthController::class, 'register']);


        Route::prefix('continueStudy')->group(function () {
            Route::get('/', [ContinueStudyController::class, 'index']);
            Route::get('/{id}', [ContinueStudyController::class, 'show']);
            Route::get('/user/{id}', [ContinueStudyController::class, 'findByUserId']);
            Route::delete('/{id}', [ContinueStudyController::class, 'destroy']);
        });


        Route::prefix('entrepreneurship')->group(function () {
            Route::get('/', [EntrepreneurshipController::class, 'index']);
            Route::get('/{id}', [EntrepreneurshipController::class, 'show']);
            Route::get('/user/{id}', [EntrepreneurshipController::class, 'findByUserId']);
            Route::delete('/{id}', [EntrepreneurshipController::class, 'destroy']);
        });


        Route::prefix('work')->group(function () {
            Route::get('/', [WorkController::class, 'index']);
            Route::get('/{id}', [WorkController::class, 'show']);
            Route::get('/user/{id}', [WorkController::class, 'findByUserId']);
            Route::delete('/{id}', [WorkController::class, 'destroy']);
        });
    });

    Route::middleware(['role:alumni'])->group(function () {
        Route::prefix('continueStudy')->group(function () {
            Route::post('/', [ContinueStudyController::class, 'store']);
            Route::post('/{id}', [ContinueStudyController::class, 'update']);
        });


        Route::prefix('work')->group(function () {
            Route::post('/', [WorkController::class, 'store']);
            Route::post('/{id}', [WorkController::class, 'update']);
        });

        Route::prefix('entrepreneurship')->group(function () {
            Route::post('/', [EntrepreneurshipController::class, 'store']);
            Route::post('/{id}', [EntrepreneurshipController::class, 'update']);
        });
    });
});
