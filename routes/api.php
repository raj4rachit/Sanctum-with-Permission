<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json([
        "status" => true,
        "message" => "API Management v1"
    ]);
});

//auth action
//Route::post('/login', [AuthController::class, 'login']);

//Route::middleware('auth:api')->group(function () {
//
//    Route::get('/me', [AuthController::class, 'me']);
//    Route::post('/logout', [AuthController::class, 'logout']);
//
//    //users route
//    Route::resource('users', UserController::class);
//
//    //roles route
//    Route::resource('roles', RoleController::class);
//});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
