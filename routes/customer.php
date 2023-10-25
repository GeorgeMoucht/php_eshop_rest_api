<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;


Route::post('/customer/{user_id}', [\App\Http\Controllers\CustomerController::class,'storeSpecific']);

// Create a customer based on Authenticated user_id.
Route::post('/customer', [\App\Http\Controllers\CustomerController::class, 'store']);

// Get customer based on Authenticated user_id.
Route::get('/customer', [\App\Http\Controllers\CustomerController::class, 'showAuthenticated']);

// Get customer based user_id
Route::get('/customer/{user_id}', [\App\Http\Controllers\CustomerController::class, 'showSpecific']);

// Customers list
// Example Url:
// 1. http://localhost:8000/api/customers
// 2. http://localhost:8000/api/customers?paginate=true&limit=1
// 3. http://localhost:8000/api/customers?paginate=true&limit=1&page=2
Route::get('/customers', [\App\Http\Controllers\CustomerController::class, 'index']);

// Update authenticated customer.
Route::put('/customers', [\App\Http\Controllers\CustomerController::class, 'updateAuthenticated']);

// Update specific customer base on user_id
Route::put('/customers/{user_id}', [\App\Http\Controllers\CustomerController::class, 'updateSpecific']);

// Delete customer
Route::delete('/customers/{user_id}', [\App\Http\Controllers\CustomerController::class, 'destroy']);
