<?php

namespace App\Http\Controllers;

use App\Library\JsonResponseData;
use App\Library\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HealthCheckController extends Controller
{
    public function getHealthCheck(Request $request): JsonResponse
    {
        return response()->json(JsonResponseData::formatData(
            $request,
            'Backend is up and running',
            Message::MESSAGE_OK,
            [
                'healthy' => true,
            ],
        ));
    }
}
