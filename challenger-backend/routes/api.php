<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\isUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post("/login", [AuthController::class, 'login']);
Route::post("/register", [AuthController::class, 'register']);
Route::middleware(isUserAuth::class)->group(function () {
    Route::post("/logout", [AuthController::class, 'logout']);
    Route::post("/getuser", [AuthController::class, 'getUser']);
});
