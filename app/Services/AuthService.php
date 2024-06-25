<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthService
{
    protected ResponseService $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user); // Generate a token for the user

        return [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => strtotime(now()->addHour())
        ];
    }

    public function logout()
    {
        $body = auth()->logout();
        if(!$body) {
            return false;
        }

        return [
            'message' => 'User successfully signed out.'
        ];
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return ['user' => $user];
    }

    public function refresh(): JsonResponse
    {
        $token = JWTAuth::refresh(); // Refresh the user's token

        return $this->responseService->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => strtotime(now()->addHour()), // Change token expiry as needed
            'user' => Auth::user(),
        ]);
    }

    public function userProfile(): JsonResponse
    {
        return $this->responseService->success(Auth::user());
    }
}
