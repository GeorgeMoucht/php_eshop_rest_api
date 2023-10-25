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
    require __DIR__.'/auth.php';
});
Route::middleware(['auth:api'])->group(function () {
    require __DIR__.'/customer.php';

    // Create Order
    Route::post('/order', [\App\Http\Controllers\OrderController::class, 'store']);
});

Route::get('/users', [\App\Http\Controllers\NeicController::class, 'index']);
Route::get('/users/{user}', [\App\Http\Controllers\NeicController::class, 'show']);
