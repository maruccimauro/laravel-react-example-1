<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvaluationController;
use App\Http\Middleware\IsTeacher;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post("/auth/login", [AuthController::class, 'login']);
Route::post("/auth/register", [AuthController::class, 'register']);
Route::middleware(IsUserAuth::class)->group(function () {
    Route::post("/auth/logout", [AuthController::class, 'logout']);
    Route::post("/auth/getuser", [AuthController::class, 'getUser']);



    Route::controller(EvaluationController::class)->group(function () {
        Route::get('/evaluations/{evaluation}', 'show');
    });

    Route::middleware(IsTeacher::class)->group(function () {
        Route::controller(EvaluationController::class)->group(function () {
            Route::get('/evaluations', 'index');
            Route::post('/evaluations', 'store');
            Route::put('/evaluations/{evaluation}', 'update');
            Route::delete('/evaluations/{evaluation}', 'destroy');
        });
    });
});
