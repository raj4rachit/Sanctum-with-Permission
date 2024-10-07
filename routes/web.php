<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json([
        "status" => true,
        "message" => "Laravel API Management v1"
    ]);
});

//Route::get('/', function () {
//    return view('welcome');
//});
