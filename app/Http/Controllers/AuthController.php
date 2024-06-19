<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\AuthService;
use App\Services\ResponseService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends ApiController
{
    protected AuthService $authService;
    protected ResponseService $responseService;

    public function __construct(AuthService $authService, ResponseService $responseService)
    {
        $this->authService = $authService;
        $this->responseService = $responseService;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    public function logout(): JsonResponse
    {
        return $this->authService->logout();
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request);
        
        if($user)
        {
            return $this->responseService->success([
                'message' => 'User successfully registered',
                'user' => $user,
            ], 201);
        }

        return $this->responseService->error('Something went wrong.', 400);
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
