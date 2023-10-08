<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if(!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Email or Password field are wrong.'], 401);
        }
        return $this->createNewToken($token);
    }

    /**
     * Register A User
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully singed out.']);
    }


    /**
     * Register A User
     *
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator =Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
        ], 201);





    }

    /**
     * Get the token array structure
     *
     * @param string $token
     *
     * @return JsonResponse
     */

    /**
     * Refresh a token
     *
     * @return JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->user());
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => strtotime(date('Y-m-d H:i:s', strtotime("+60 min"))),
            'user' => auth()->user()
        ]);
    }


}
