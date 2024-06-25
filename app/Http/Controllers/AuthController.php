<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends ApiController
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
//        return $this->authService->login($request);
        $authResponse = $this->authService->login($request);

        if($authResponse === false) {
            return $this->apiErrorResponse(
                payload: ['message' => 'Email or Password field are wrong.'],
                status: 401,
                method: __METHOD__,
                httpStatusCode: 401
            );
        }

        return $this->apiResponse(
            payload: $authResponse,
            status: 200,
            method: __METHOD__
        );
    }

    public function logout(): JsonResponse
    {
        $logoutResponse = $this->authService->logout();

        if($logoutResponse === false) {
            return $this->apiErrorResponse(
                payload: ['message' => 'Something went wrong. Please try again'],
                status: 401,
                method: __METHOD__,
                httpStatusCode: 401
            );
        }

        return $this->apiResponse(
            payload: $logoutResponse,
            status: 200,
            method: __METHOD__
        );
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $registerResponse = $this->authService->register($request);

        if($registerResponse === false) {
            return $this->apiErrorResponse(
                payload: ['message' => 'Something went wrong. Please try again'],
                status: 401,
                method: __METHOD__,
                httpStatusCode: 401
            );
        }

        return $this->apiResponse(
            payload: $registerResponse,
            status: 200,
            method: __METHOD__,
            httpStatusCode: 200
        );
//        return $this->authService->register($request);
    }

    public function refresh(): JsonResponse
    {
        return $this->authService->refresh();
    }

    public function userProfile(): JsonResponse
    {
        return $this->authService->userProfile();
    }
}
