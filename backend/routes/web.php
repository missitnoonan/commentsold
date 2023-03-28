<?php

use Illuminate\Support\Facades\Route;

Route::fallback([\App\Http\Controllers\FallBackController::class, 'fallback']);
