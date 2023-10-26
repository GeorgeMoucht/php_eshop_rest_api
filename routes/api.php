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
    // All customer related requests.
    Route::prefix('/customer')->group(function () {

        // Customers list
        // Example Url:
        // 1. http://localhost:8000/api/customers
        // 2. http://localhost:8000/api/customers?paginate=true&limit=1
        // 3. http://localhost:8000/api/customers?paginate=true&limit=1&page=2
        Route::get('', [\App\Http\Controllers\CustomerController::class, 'index']);

        // Create a customer based on Authenticated user.
        Route::post('register', [\App\Http\Controllers\CustomerController::class, 'store']);

        // Get customer based on Authenticated user.
        Route::get('profile', [\App\Http\Controllers\CustomerController::class, 'showAuthenticated']);

        // Update authenticated customer.
        Route::put('/', [\App\Http\Controllers\CustomerController::class, 'updateAuthenticated']);

        // With Specific user_id.
        Route::prefix('{user_id}')->group(function () {
            // Create customer based user_id.
            Route::post('', [\App\Http\Controllers\CustomerController::class, 'storeSpecific']);

            // Get customer based user_id
            Route::get('', [\App\Http\Controllers\CustomerController::class, 'showSpecific']);

            // Update specific customer base on user_id
            Route::put('', [\App\Http\Controllers\CustomerController::class, 'updateSpecific']);

            // Delete customer
            Route::delete('', [\App\Http\Controllers\CustomerController::class, 'destroy']);
        });
    });



    // Create Order
    Route::post('/order', [\App\Http\Controllers\OrderController::class, 'store']);
});

// Both two are test routes. Should be deleted.
Route::get('/users', [\App\Http\Controllers\NeicController::class, 'index']);
Route::get('/users/{user}', [\App\Http\Controllers\NeicController::class, 'show']);
