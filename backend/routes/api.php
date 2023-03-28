<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Library\JsonResponseData;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return response()->json([]);
});

Route::post('/register', [Controllers\ApiAuthController::class, 'postRegister']);
Route::post('/login', [Controllers\ApiAuthController::class, 'postLogin']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user', [Controllers\ApiUserController::class, 'getUser']);
    Route::post('/password', [Controllers\ApiUserController::class, 'postResetPassword']);
    Route::post('/logout', [Controllers\ApiAuthController::class, 'postLogout']);
    Route::post('/refresh', [Controllers\ApiAuthController::class, 'postRefresh']);
});
