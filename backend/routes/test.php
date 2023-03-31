<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/test', [Controllers\TestController::class, 'getTest']);
