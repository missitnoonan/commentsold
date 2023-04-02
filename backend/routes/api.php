<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/health-check', [Controllers\HealthCheckController::class, 'getHealthCheck']);

Route::post('/register', [Controllers\ApiAuthController::class, 'postRegister']);
Route::post('/login', [Controllers\ApiAuthController::class, 'postLogin']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user', [Controllers\ApiUserController::class, 'getUser']);
    Route::post('/password', [Controllers\ApiUserController::class, 'postResetPassword']);
    Route::post('/logout', [Controllers\ApiAuthController::class, 'postLogout']);
    Route::post('/refresh', [Controllers\ApiAuthController::class, 'postRefresh']);

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [Controllers\ProductController::class, 'list']);
        Route::get('/{id}', [Controllers\ProductController::class, 'view']);
    });

    Route::group(['prefix' => 'inventory'], function () {
        Route::get('/', [Controllers\InventoryController::class, 'list']);
        Route::get('/stats', [Controllers\InventoryController::class, 'stats']);
        Route::get('/{id}', [Controllers\InventoryController::class, 'view']);
    });
});
