<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(),442);
        }

        // Create a new user
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return $this->login($request);
    }

    public function login(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Attempt to authenticate the user
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message'=> 'Unauthorized'], 401);
        }

        // Generate a JWt token
        $token = Auth::user()->createToken('authToken')->accessToken;

        // Return just the token string in the response
        return response()->json([
            'token' => $token,
            'message' => 'Login successful.'
        ], 200);
    }
    public function logout(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            Auth::user()->tokens->each(function ($token, $key) {
                $token->delete();
            });

            return response()->json(['message' => 'Logged out successfully'], 200);
        }

        return response()->json(['message' => 'User not authenticated'], 401);
    }
}
