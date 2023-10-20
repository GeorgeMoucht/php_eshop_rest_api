<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
Route::middleware(['auth:api'])->group(function () {
    Route::post('/customer/{user_id}', [\App\Http\Controllers\CustomerController::class,'storeSpecific']);
    // Create a customer based on Authenticated user_id.
    Route::post('/customer', [\App\Http\Controllers\CustomerController::class, 'store']);
    // Get customer based on Authenticated user_id.
    Route::get('/customer', [\App\Http\Controllers\CustomerController::class, 'showAuthenticated']);
    // Get customer based user_id
    Route::get('/customer/{user_id}', [\App\Http\Controllers\CustomerController::class, 'showSpecific']);
});

Route::get('/users', [\App\Http\Controllers\NeicController::class, 'index']);
Route::get('/users/{user}', [\App\Http\Controllers\NeicController::class, 'show']);
