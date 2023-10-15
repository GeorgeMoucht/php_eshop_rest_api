<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// All the controllers will extend this class.
class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function apiResponse(array $payload, int $status, $method, int $httpStatusCode = 200){
        return response()->json($this->payload($payload, $status, $method), $httpStatusCode);
    }

    protected function apiErrorResponse(array $payload, int $status, $method, int $httpStatusCode = 200){
        return response()->json($this->payload($payload, $status, $method, true), $httpStatusCode);
    }

    private function payload(array $data, int $status, $method,  bool|int $error = false){
        return [
            'error' => $error,
            'data' => $data,  //main extention   []
            'status' => $status,
            'method' => $method,
            'version' => '1.0.0.'
         ];
    }
}
