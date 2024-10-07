<?php

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json([
        "status" => true,
        "message" => "API Management v1"
    ]);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/users/{id}/assign-role', [UserController::class, 'assignRole'])->name('assign.role');
    Route::get('/users/{id}/roles', [UserController::class, 'getRoles'])->name('get.roles');

    // Uncomment these lines to enable user and role routes
    Route::resource('users', UserController::class);
    // Route::resource('roles', RoleController::class);
});

// Authentication actions
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [RegisterController::class, 'login'])->name('login');

