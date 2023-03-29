<?php

namespace App\Http\Controllers;

use App\Library\JsonResponseData;
use App\Library\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FallBackController extends Controller
{
    public function fallback(Request $request): JsonResponse
    {
        return response()->json(JsonResponseData::formatData(
            $request,
            'This route is not supported by the API',
            Message::MESSAGE_WARNING), 404);
    }
}
