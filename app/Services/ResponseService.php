<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Psy\Util\Json;

class ResponseService
{
    public function success($data, $status = 200): JsonResponse
    {
        return response()->json(['data' => $data], $status);
    }

    public function error($message, $status = 400): JsonResponse
    {
        return response()->json(['error' => $message],$status);
    }
}
