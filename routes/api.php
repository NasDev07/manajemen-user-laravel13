<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
  /**
   * User Statistics Endpoint
   * Returns statistics based on the authenticated user's role
   */
  Route::get('/statistics', [UserController::class, 'getStatistics']);

  /**
   * User Resource Endpoints
   * Full CRUD operations on users with role-based authorization
   */
  Route::apiResource('users', UserController::class);

  /**
   * Update user's last login timestamp
   */
  Route::patch('/users/{user}/last-login', [UserController::class, 'updateLastLogin']);

  /**
   * Current User Information
   */
  Route::get('/user', function (Request $request) {
    return $request->user()->load(['roles.permissions']);
  });

  /**
   * Profile Update Endpoint
   * Allow users to update their own profile
   */
  Route::patch('/profile', [UserController::class, 'updateProfile']);

  /**
   * Logout Endpoint
   */
  Route::post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();
    return response()->json(['message' => 'Logged out successfully']);
  });
});

/**
 * Public Routes (if needed for registration, login, etc.)
 * Add your public routes here
 */
Route::middleware('guest')->group(function () {
  // Login and registration routes would go here
});
