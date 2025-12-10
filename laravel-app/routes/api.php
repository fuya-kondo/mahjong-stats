<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserGameController;
use App\Http\Controllers\RankingController;

Route::get('/games', [GameController::class, 'index']);
Route::post('/games', [GameController::class, 'store']);
Route::get('/users/{id}/stats', [UserController::class, 'stats']);
Route::get('/users/{id}/games', [UserController::class, 'games']);
Route::get('/users/{id}/games', [UserGameController::class, 'index']);
Route::get('/groups/{id}/stats', [GroupController::class, 'stats']);
Route::get('/groups/{id}/ranking', [RankingController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/games', [GameController::class, 'store']); // ← 試合登録はログイン必須
});

